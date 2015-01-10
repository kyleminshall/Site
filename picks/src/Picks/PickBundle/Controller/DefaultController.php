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
        $con=mysqli_connect("localhost","KyleM","Minshall1!", "picks"); //Connect to database
		
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $query) or trigger_error(mysqli_error()." ".$query);
        $row = mysqli_fetch_assoc($result);
        
		if($password === $row['password']) //Check to see if their entered password matches the one from their table entry
		{
			mysqli_close($con);
            $session->set("authorized", true);
            $session->set("name", $row['name']);
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
        $query = "INSERT INTO picks (`email`, `choices`) VALUES ('$name', '$pick1, $pick2, $pick3, $pick4')";
        mysqli_query($con, $query) or trigger_error(mysqli_error($con)." ".$query);
        $query = "UPDATE users SET picked=1 WHERE name='$name'";
        mysqli_query($con, $query) or trigger_error(mysqli_error($con)." ".$query);
    }
    
    public function picked($name) {
        $con=mysqli_connect("localhost","KyleM","Minshall1!", "picks"); //Connect to database
        
        if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error(); //If that fails, display an error (obviously)
		}
        
        $query = "SELECT * FROM users WHERE name='$name' AND picked=0";
        $result = mysqli_query($con, $query) or trigger_error(mysqli_error($con)." ".$query);
        return mysqli_num_rows($result) < 1;
    }
}
