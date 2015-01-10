<?php

namespace Picks\PickBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();
        
    	if($_POST && !empty($_POST['pick1']) && !empty($_POST['pick2']) && !empty($_POST['pick3']) && !empty($_POST['pick4']))
    		self::submit($_POST['pick1'], $_POST['pick2'], $_POST['pick3'], $_POST['pick4'], $session);
        
         
        if(!self::confirm($session))
            return $this->redirect($this->generateUrl('login'));
        
        $name = $session->get("name", "User");
        $picked = self::picked($name);
        
        return $this->render('PicksPickBundle:Default:index.html.twig', array("name" => $name, "picked" => $picked));
    }
    
    public function loginAction()
    {
        $session = $this->getRequest()->getSession();
        
    	if($_POST && !empty($_POST['email']) && !empty($_POST['password']))
    		$response = self::validate($_POST['email'], $_POST['password'], $session);	//Validate the user when they click submit on the login
        
        
        if(isset($response) && $response)
            return $this->redirect($this->generateUrl('home'));
        else if(isset($response))
            return $this->render('PicksPickBundle:Default:login.html.twig', array('error' => $response));
        else
            return $this->render('PicksPickBundle:Default:login.html.twig');
    }
    
    public function logoutAction() 
    {
        $session = $this->getRequest()->getSession();
        $session->clear();
        return $this->redirect($this->generateUrl('login'));
    }
    
    public function confirm($session) {
        return $session->get("authorized", false);
    }
    
    public function validate($email, $password, $session) {
        $con = mysqli_connect("localhost","KyleM","Minshall1!", "picks"); //Connect to database
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM users WHERE email=?");
        $stmt -> bind_param('s',$email);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        $row = $rs->fetch_all(MYSQLI_ASSOC);
        
		if($password === $row[0]['password']) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
            $session->set("name", $row[0]['name']);
            return true;
		}
		else
		{
			mysqli_close($con);
			return "Wrong email or password";
		}
    }
    
    public function submit($pick1, $pick2, $pick3, $pick4, $session) {
        $con=mysqli_connect("localhost","KyleM","Minshall1!", "picks"); //Connect to database
        
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        $name = $session->get("name", NULL);
        
        $stmt = $con->prepare("INSERT INTO picks (`email`, `choices`) VALUES (?, '$pick1, $pick2, $pick3, $pick4')");
        $stmt -> bind_param('s', $name);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        
        $stmt = $con->prepare("UPDATE users SET picked=1 WHERE name=?");
        $stmt -> bind_param('s',$name);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
    }
    
    public function picked($name) {
        $con=mysqli_connect("localhost","KyleM","Minshall1!", "picks"); //Connect to database
        
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $stmt = $con->prepare("SELECT * FROM users WHERE name=? AND picked=0");
        $stmt -> bind_param('s',$name);
        
        $result = $stmt->execute() or trigger_error(mysqli_error()." ".$query);
        $rs = $stmt->get_result();
        
        return mysqli_num_rows($rs) < 1;
    }
}
