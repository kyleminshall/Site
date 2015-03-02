<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CodeController extends Controller
{
    public function codeAction()
    {
		 $logger = $this->get('logger');
		
         $session = $this->getRequest()->getSession();
		 if($session->get('teacher', false))
			 $teacher = $session->get('id');
		 else
			 $teacher = $session->get('teacher_id', 0);
         
         if(!($session->get("authorized", false)))
             return $this->redirect($this->generateUrl('compiler_login'));
         
         $con = self::connect();
		 
		 $problems = array();
		 
		 $categories = array();
		 $result = mysqli_query($con, "SELECT category FROM problems GROUP BY category ORDER BY sorting ASC");
		 
		 while($row = $result->fetch_assoc()) {
			 $categories[] = $row['category'];
		 }
		 
		 $id = $session->get('id');
		 $temp = mysqli_fetch_all(mysqli_query($con, "SELECT title FROM progress LEFT JOIN problems ON problem_id = problems.id WHERE user_id=$id"), MYSQLI_ASSOC);
		 $done = array();
		 
		 foreach($temp as $key => $value)
			 $done[] = $value['title'];
		 
		 foreach($categories as $category)
		 {
	         $titles = array();
	         $ids = array();
			 
	         $result = mysqli_query($con, "SELECT id,title,category,teacher FROM problems WHERE (teacher=0 OR teacher=$teacher) AND category='$category'");
		 
	         while($row = $result->fetch_assoc()) 
			 {
				 if(in_array($row['title'], $done) && !$session->get('teacher', false))
					 $titles[$row['title']] = true;
				 else
					 $titles[$row['title']] = false;
	             $ids[] = $row['id'];
	         }
			 $category = ucfirst($category);
			 $problems[$category] = array('titles' => $titles, 'ids' => $ids);
		 }
             
         return $this->render('PersonalBundle:Code:index.html.twig', array('problems' => $problems, 'email' => $session->get('username'), 'teacher' => $session->get('teacher', false)));
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
	
	public function login_teacherAction()
	{
        $session = $this->getRequest()->getSession();
         
     	if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
     		$response = self::validate_teacher($_POST['username'], $_POST['password'], $session);
        
        if(isset($response) && $response)
            return $this->redirect($this->generateUrl('teacher_admin'));
        else if(isset($response))
            return $this->render('PersonalBundle:Code:login_teacher.html.twig', array('error' => "Wrong username or password"));
        else
            return $this->render('PersonalBundle:Code:login_teacher.html.twig');
	}

    
    public function problemAction($problem)
    {
        $session = $this->getRequest()->getSession();
        if(!($session->get("authorized", false)))
            return $this->redirect($this->generateUrl('compiler_login'));
        
        $con = self::connect();
        
        $stmt = $con->prepare("SELECT * FROM problems WHERE id=?");
        $stmt -> bind_param('s',$problem);
        
        $result = $stmt->execute() or trigger_error(mysqli_error());
        $rs 	= $stmt->get_result();
        $row 	= $rs->fetch_all(MYSQLI_ASSOC);
        $row 	= $row[0];
        
        $title 		= $row['title'];
        $prompt 	= $row['prompt'];
        $method		= $row['method'];
        $test 		= $row['test'];
        $output		= $row['output'];
        $timeout	= $row['timeout'];
        
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
		if(empty($return['all']))
			$all = false;
		else
			$all = true;
		$stmt->close();
        
        if(isset($return)) {
			if($all && !$session->get('teacher')) {
				$id = $session->get('id');
				$check = mysqli_query($con, "SELECT * FROM progress WHERE user_id='$id' AND problem_id='$problem'");
				if(mysqli_num_rows($check) == 0) {
					$query = "INSERT INTO progress (`user_id`, `problem_id`) VALUES ('$id', '$problem')";
					$stmt = $con->prepare($query);
					$stmt->execute();
				}
			}
            return $this->render('PersonalBundle:Code:problem.html.twig', 
                    array('title' => $title, 'prompt' => $prompt, 'method' => $method, 'tests' => explode(' ', $test), 
					'expected' => explode(',', $output), 'output' => $error, 'code' => $return['code'], 'pass' => $pass, 
					'inputs' => $inputs, 'email' => $session->get('username'), 'teacher' => $session->get('teacher',false)));
		}
        else
            return $this->render('PersonalBundle:Code:problem.html.twig', 
                            array('title' => $title, 'prompt' => $prompt, 'method' => $method, 
							'email' => $session->get('username'), 'teacher' => $session->get('teacher',false)));
        
    }
	
	public function adminAction()
	{
		$session = $this->getRequest()->getSession();
		if(!$session->get('teacher',false))
			return $this->redirect($this->generateUrl('compiler_login'));
		
		$students = self::getStudents($session->get('id'));
		$problems = self::getProblems($session->get('id'));
		
		return $this->render('PersonalBundle:Code:admin.html.twig', array('email' => $session->get('username'), 'teacher' => $session->get('teacher', false), 'students' => $students, 'id' => $session->get('id'), 'problems' => $problems));
	}
	
	public function getStudents($id)
	{
		$con = self::connect();
        if(mysqli_connect_errno()) 
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		
		$stmt = $con->prepare("SELECT id, email, username FROM users WHERE teacher=?");
		$stmt->bind_param('i', $id);
		
		$result = $stmt->execute() or trigger_error(mysqli_error());
		$rs = $stmt->get_result();
		
		$students = $rs->fetch_all(MYSQLI_ASSOC);
		return $students;
	}
	
	public function getProblems($id)
	{
		$con = self::connect();
		
        if(mysqli_connect_errno()) 
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		
		$stmt = $con->prepare("SELECT title, method FROM problems WHERE teacher=$id");
		
		$result = $stmt->execute() or trigger_error(mysqli_error());
		$rs = $stmt->get_result();
		
		$problems = $rs->fetch_all(MYSQLI_ASSOC);
		
		return $problems;
	}
    
    public function validate($username, $password, $session) 
	{
        $con = self::connect();
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM users WHERE username=?");
        $stmt -> bind_param('s',$username);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
        
		if($password === $row[0]['password']) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
			$session->set("username", $username);
			$session->set("id", $row[0]['id']);
			$session->set("teacher_id", $row[0]['teacher']);
            return true;
		}
		else
		{
			mysqli_close($con);
			return false;
		}
    }
	
    public function validate_teacher($username, $password, $session) 
	{
        $con = self::connect();
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM teachers WHERE username=?");
        $stmt -> bind_param('s',$username);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
        
		if($password === $row[0]['password']) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
			$session->set("username", $username);
			$session->set("id", $row[0]['id']);
			$session->set("teacher", true);
            return true;
		}
		else
		{
			mysqli_close($con);
			return false;
		}
    }
	
	public function signupAction()
	{
		if($_GET && empty($_GET['key']))
			return $this->render('PersonalBundle:Code:signup.html.twig', array('email' => "", 'error' => true, 'message' => "Missing permission key"));
		
		if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_GET['key']))
		{
			$con = self::connect();
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			$key = $_GET['key'];
			
	        if(mysqli_connect_errno()) 
			  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
			
			$query = "SELECT * FROM users WHERE username=?";
			$stmt = $con->prepare($query);
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0)
				return $this->render('PersonalBundle:Code:signup.html.twig', array('email' => $email, 'error' => false, 'message' => "Username has already been taken"));
			$stmt->close();
			$query = "SELECT teacher,email FROM permission WHERE `key`=?";
			$stmt = $con->prepare($query);
			$stmt->bind_param('s', $key);
			$stmt->execute();
			$rs = $stmt->get_result();
			$row = $rs->fetch_all(MYSQLI_ASSOC);
			$teacher = $row[0]['teacher'];
			$email = $row[0]['email'];
			
			$query = "INSERT INTO users (`email`,`username`, `password`, `teacher`) VALUES ('$email', ?, ?, '$teacher')";
			$stmt = $con->prepare($query);
			$stmt->bind_param('ss', $username, $password);
			$rs = $stmt->execute();
			$stmt->close();
			$stmt = $con->prepare("UPDATE permission SET used=1 WHERE `key`='$key'");
			$stmt->execute();
			return $this->redirect($this->generateUrl('compiler'));
		}
		
		if($_GET && !empty($_GET['key']))
		{
			$key = $_GET['key'];
			$con = self::connect();
		
	        if(mysqli_connect_errno()) 
			  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
			
			$query = "SELECT email FROM permission WHERE `key`=? AND used=0";
			$stmt = $con->prepare($query);
			$stmt -> bind_param('s', $key);
			
			$result = $stmt->execute();
	        $rs = $stmt->get_result();
	        $row = $rs->fetch_all(MYSQLI_ASSOC);
			
			if(empty($row)) {
				$email = "Email";
				$error = true;
				return $this->render('PersonalBundle:Code:signup.html.twig', array('email' => $email, 'error' => true, 'message' => "Invalid permission key."));
			}
			else
				$email = $row[0]['email'];
			
			$stmt->close();
			$con->close();
			
			return $this->render('PersonalBundle:Code:signup.html.twig', array('email' => $email, 'error' => false));
		}
		
		return $this->render('PersonalBundle:Code:signup.html.twig', array('email' => "Email", 'error' => true, 'message' => "There was an error processing your request. Please try again."));
	}
	
	public function teacher_signupAction()
	{	
		if($_POST && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['key']))
		{
			$con = self::connect();
			
			$username = $_POST['username'];
			$password = $_POST['password'];
			$key 	  = $_POST['key'];
			
	        if(mysqli_connect_errno()) 
			  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
			
			$query = "SELECT * FROM teachers WHERE username=?";
			$stmt = $con->prepare($query);
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows > 0)
				return $this->render('PersonalBundle:Code:teacher_signup.html.twig', array('email' => $email, 'error' => false, 'message' => "Username has already been taken"));
			
			$stmt->close();
			$query = "SELECT email FROM pem WHERE `key`=?";
			$stmt = $con->prepare($query);
			$stmt->bind_param('s', $key);
			$stmt->execute();
			$rs = $stmt->get_result();
			$row = $rs->fetch_all(MYSQLI_ASSOC);
			$email = $row[0]['email'];
			
			$query = "INSERT INTO teachers (`email`,`username`, `password`) VALUES ('$email', ?, ?)";
			$stmt = $con->prepare($query);
			$stmt->bind_param('ss', $username, $password);
			$rs = $stmt->execute();
			$stmt->close();
			$stmt = $con->prepare("UPDATE pem SET used=1 WHERE `key`='$key'");
			$stmt->execute();
			
			$session = $this->getRequest()->getSession();
			return $this->redirect($this->generateUrl('login_teacher'));
		}
	
		$key = $_GET['key'];
		$con = self::connect();
	
        if(mysqli_connect_errno()) 
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		
		$query = "SELECT email FROM pem WHERE `key`=? AND used=0";
		$stmt = $con->prepare($query);
		$stmt -> bind_param('s', $key);
		
		$result = $stmt->execute();
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
		
		if(empty($row)) {
			$email = "Email";
			$error = true;
			return $this->render('PersonalBundle:Code:teacher_signup.html.twig', array('email' => $email, 'key' => $key, 'error' => true, 'message' => "Invalid permission key."));
		}
		else
			$email = $row[0]['email'];
		
		$stmt->close();
		$con->close();
		
		return $this->render('PersonalBundle:Code:teacher_signup.html.twig', array('email' => $email, 'key' => $key, 'error' => false));
		
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
        $header = "#include <iostream>\n#include <cmath>\n#include <vector>\nusing namespace std;\n\n";
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
        $logger = $this->get('logger');
        $proc = proc_open('g++ -fno-gnu-keywords -Dasm=prohibited -D__asm__=prohibited --std=c++11 '.$file_name.' -o test.out;', $descriptorspec, $pipes);
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
                $all = false;
            } 
            else {
                if(!empty(stream_get_contents($pipes[2]))) {
                    $return = stream_get_contents($pipes[2]);
                    $all = false;
                }   
                else {
                    $out = stream_get_contents($pipes[1]);
					$logger->info($out);
                    $out = preg_replace('/[\r\n]+/', ',', $out);
					$logger->info($out);
					$compare = self::compare(rtrim($out, ","), $output);
                    $pass = $compare['result'];
					$all = $compare['all'];
                    $values = explode(',', $out);
                    $return = "";
                }
                fclose($pipes[1]);
                proc_close($process);
            }
        }
        else {
            proc_close($proc);
            $all = false;
        }
        if(file_exists($file_name))
            unlink($file_name);
        if(file_exists('test.out'))
            unlink('test.out');
        
        return array('output' => $return, 'code' => $code, 'pass' => $pass, 'input' => $values, 'all' => $all);
    }
    
    public function compare($initial, $compare)
    {
		$counter = 0;
        $result = array();
        
        $initial = explode(',', $initial);
        $compare = explode(',', $compare);
        
        for($i = 0; $i < count($initial); $i++) 
		{
			$initial[$i] === $compare[$i] ? $counter++ : '';
            $result[] = (preg_replace('/[\r\n]+/', '', $initial[$i]) === $compare[$i]) ? "true" : "false";
        }
		
		$all = ($counter == sizeof($initial));
        return array('result' => $result, 'all' => $all);
    }
	
    public function connect()
    {
        return mysqli_connect("localhost","KyleM","Minshall1!", "Site"); //Connect to database
    }
}