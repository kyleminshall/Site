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

         if($_POST && isset($_POST['code']))
             $output = self::evaluate($_POST['code'], $_POST['type'], $_POST['name']);
         
         $output['pass'] = (str_replace('\n', '', $output['output']) === "Hello World");

         if(isset($output))
             return $this->render('PersonalBundle:Code:index.html.twig', array('output' => $output['output'], 'code' => $output['code'], 'pass' => $output['pass']));
         else
             return $this->render('PersonalBundle:Code:index.html.twig');
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
    
    public function validate($username, $password, $session) {
        $con = mysqli_connect("localhost","KyleM","Minshall1!", "Site"); //Connect to database
		
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
    
    public function evaluate($code, $type, $name)
    {
        $pass = false;
        $date = date("Ymdhms");
        $file_name = $date.".cpp";
        chdir("/opt/files");
        error_log(getcwd());
        $myfile = fopen($file_name, 'w');
        $header = "#include <iostream>\nusing namespace std;\n\n";
        $main = "\n\nint main()\n{\n\t".$name.";\n}";
        fwrite($myfile, $header);
        fwrite($myfile, str_replace("\r", '', $code));
        fwrite($myfile, $main);
        fclose($myfile);
        
        $descriptorspec = array(
           0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
           1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
           2 => array("pipe", "w") // stderr is a file to write to
        );
        
        $proc = proc_open('g++ '.$file_name.' -o test.out;', $descriptorspec, $pipes);
        $output = "Compiler Error: ".stream_get_contents($pipes[2]);
        if(file_exists('test.out')) {
            proc_close($proc);
            $process = proc_open('./test.out', $descriptorspec, $pipes);
            sleep(1);
            $status = proc_get_status($process);
            if($status['running']) {
                $output = "Took too long — Check for any infinite loops.";
                proc_terminate($process);
            } 
            else {
                if(!empty(stream_get_contents($pipes[2])))
                    $output = stream_get_contents($pipes[2]);
                else {
                    $output = stream_get_contents($pipes[1]);
                    $pass = true;
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
        
        return array('output' => $output, 'code' => $code, 'pass' => $pass);;
    }
}