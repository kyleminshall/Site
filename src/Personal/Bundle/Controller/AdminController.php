<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

include('database.php');

class AdminController extends Controller
{
	public function indexAction()
	{
		$session = $this->getRequest()->getSession();
		
        if(!($session->get("authorized", false)))
            return $this->redirect($this->generateUrl('admin_login'));
		
		$teachers = self::getTeachers();
		$problems = self::getProblems();
		$username = $session->get('username');
		
		return $this->render('PersonalBundle:Admin:index.html.twig', array('teachers' => $teachers, 'problems' => $problems, 'username' => $username));
	}
	
	public function getTeachers()
	{
		$con = self::connect();
		
        if(mysqli_connect_errno()) 
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		
		$stmt = $con->prepare("SELECT id, email, username FROM teachers");
		
		$result = $stmt->execute() or trigger_error(mysqli_error());
		$rs = $stmt->get_result();
		
		$teachers = $rs->fetch_all(MYSQLI_ASSOC);
		return $teachers;
	}
	
	public function getProblems()
	{
		$con = self::connect();
		
        if(mysqli_connect_errno()) 
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		
		$stmt = $con->prepare("SELECT title, method FROM problems");
		
		$result = $stmt->execute() or trigger_error(mysqli_error());
		$rs = $stmt->get_result();
		
		$problems = $rs->fetch_all(MYSQLI_ASSOC);
		
		return $problems;
	}
	
	public function loginAction()
	{
		$session = $this->getRequest()->getSession();
		
     	if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
     		$response = self::validate($_POST['username'], $_POST['password'], $session);	//Validate the user when they click submit on the login
		
        if(isset($response) && $response)
            return $this->redirect($this->generateUrl('admin_home'));
        else if(isset($response))
            return $this->render('PersonalBundle:Admin:adminLogin.html.twig', array('error' => "Wrong username or password"));
        else
            return $this->render('PersonalBundle:Admin:adminLogin.html.twig');
	}
	
	public function logoutAction()
	{
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('admin_login'));
	}
	
    public function validate($username, $password, $session) 
	{
        $con = self::connect();
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM admins WHERE username=?");
        $stmt -> bind_param('s',$username);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
		$hash = $row[0]['password'];
        
		if(password_verify($password, $hash)) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
			$session->set("username", $username);
			$session->set("admin", true);
			$session->set("id", $row[0]['id']);
            return true;
		}
		else
		{
			mysqli_close($con);
			return false;
		}
    }
	
    public function connect()
    {
        return mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB); //Connect to database
    }
}
