<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CodeController extends Controller
{
    public function codeAction()
    {
         $session = $this->getRequest()->getSession();
         
         if(!($session->get("authorized", false)))
             return $this->redirect($this->generateUrl('compiler_login'));
         
         $con = self::connect();
         
         $result = mysqli_query($con, "SELECT id,title FROM problems");
         
         $titles = array();
         $ids = array();
         
         while($row = $result->fetch_assoc()) {
             array_push($titles, $row['title']);
             array_push($ids, $row['id']);
         }
             
         return $this->render('PersonalBundle:Code:index.html.twig', array('titles' => $titles, 'ids' => $ids));
    }
    
    public function loginAction()
    {
        $session = $this->getRequest()->getSession();
         
     	if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
     		$response = self::validate($_POST['username'], $_POST['password'], $session);	//Validate the user when they click submit on the login
        
        if(isset($response) && $response)
            return $this->redirect($this->generateUrl('compiler'));
        else if(isset($response))
            return $this->render('PersonalBundle:Code:login.html.twig', array('error' => "Wrong username or password"));
        else
            return $this->render('PersonalBundle:Code:login.html.twig');
    }

    
    public function problemAction($problem)
    {
        $logger = $this->get('logger');
        $session = $this->getRequest()->getSession();
        if(!($session->get("authorized", false)))
            return $this->redirect($this->generateUrl('compiler_login'));
        
        $con = self::connect();
        
        $stmt = $con->prepare("SELECT * FROM problems WHERE id=?");
        $stmt -> bind_param('s',$problem);
        
        $result = $stmt->execute() or trigger_error(mysqli_error());
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
        $row = $row[0];
        
        $title = $row['title'];
        $prompt = $row['prompt'];
        $method = $row['method'];
        $test = $row['test'];
        $output = $row['output'];
        $timeout = $row['timeout'];
        
        if($_POST && isset($_POST['code']))
            $return = self::evaluate($_POST['code'], $method, $test, $output, $timeout);
        
        if(empty($return['output']))
            $error = false;
        else
            $error = $return['output'];
        
        if(empty($return['pass']))
            $pass = false;
        else
            $pass = $return['pass'];
        
        if(empty($return['input']))
            $inputs = false;
        else {
            $inputs = $return['input'];
        }
        
        if(isset($return))
            return $this->render('PersonalBundle:Code:problem.html.twig', 
                    array('title' => $title, 'prompt' => $prompt, 'method' => $method, 'tests' => explode(' ', $test), 'expected' => explode(',', $output), 'output' => $error, 'code' => $return['code'], 'pass' => $pass, 'inputs' => $inputs));
        else
            return $this->render('PersonalBundle:Code:problem.html.twig', 
                            array('title' => $title, 'prompt' => $prompt, 'method' => $method));
        
    }
    
    public function validate($username, $password, $session) {
        $con = self::connect();
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM code WHERE username=?");
        $stmt -> bind_param('s',$username);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
        
		if($password === $row[0]['password']) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
            return true;
		}
		else
		{
			mysqli_close($con);
			return false;
		}
    }
    
    public function logoutAction() 
    {
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('compiler_login'));
    }
    
    public function evaluate($code, $method, $test, $output, $timeout)
    {
        $pass = false;
        $values = "";
        $date = date("Ymdhms");
        $file_name = $date.".cpp";
        $test = explode(' ', $test);
        chdir("/opt/files");
        error_log(getcwd());
        $myfile = fopen($file_name, 'w');
        $header = "#include <iostream>\n#include <cmath>\nusing namespace std;\n\n";
        $dec = $method."\n{\n";
        $end = "}\n";
        $main = "\n\nint main()\n{\n";
        fwrite($myfile, $header);
        fwrite($myfile, $dec);
        fwrite($myfile, "\t".str_replace("\r", '', $code)."\n");
        fwrite($myfile, $end);
        fwrite($myfile, $main);
        foreach($test as $val)
            fwrite($myfile, "\tcout<<boolalpha<<".$val."<<endl;\n");
        fwrite($myfile, $end);
        fclose($myfile);
        
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
           2 => array("pipe", "w")   // stderr is a pipe to write to
        );
        
        $proc = proc_open('g++ -fno-gnu-keywords -Dasm=prohibited -D__asm__=prohibited '.$file_name.' -o test.out;', $descriptorspec, $pipes);
        $return = "Compiler Error: ".stream_get_contents($pipes[2]);
        if(file_exists('test.out')) {
            proc_close($proc);
            $handle = popen("ulimit -v 30000", "r");
            $process = proc_open('nice -n10 ./test.out', $descriptorspec, $pipes);
            sleep($timeout);
            $status = proc_get_status($process);
            if($status['running']) {
                proc_terminate($process);
                $return = "Error: Process took to long. Check for any infinite loops.";
            } 
            else {
                if(!empty(stream_get_contents($pipes[2]))) {
                    $return = stream_get_contents($pipes[2]);
                }   
                else {
                    $out = stream_get_contents($pipes[1]);
                    $out = preg_replace('/[\r\n]+/', ',', $out);
                    $pass = self::compare(rtrim($out, ","), $output);
                    $values = explode(',', $out);
                    $return = "";
                }
                fclose($pipes[1]);
                proc_close($process);
            }
        }
        else {
            proc_close($proc);
        }
        if(file_exists($file_name))
            unlink($file_name);
        if(file_exists('test.out'))
            unlink('test.out');
        
        return array('output' => $return, 'code' => $code, 'pass' => $pass, 'input' => $values);
    }
    
    public function compare($initial, $compare)
    {
        $logger = $this->get('logger');
        $result = array();
        
        $initial = explode(',', $initial);
        $compare = explode(',', $compare);
        
        for($i = 0; $i < count($initial); $i++) {
            array_push($result, (preg_replace('/[\r\n]+/', '', $initial[$i]) === $compare[$i]) ? "true" : "false");
        }
        return $result;
    }
    
    public function connect()
    {
        return mysqli_connect("localhost","KyleM","Minshall1!", "Site"); //Connect to database
    }
}