<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{
	public function addStudentAction()
	{
		$logger = $this->get('logger');
		$generator = new SecureRandom();
		$random = $generator->nextBytes(16);
		
		$email = $_POST['email'];
		$key = bin2hex($random);
		$teacher = $_POST['id'];
		
		$con = self::connect();
		
		$query = "SELECT * FROM users WHERE email=?";
		$stmt = $con->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			return new JsonResponse(array('status' => 400, 'message' => "Student is already enrolled!"));
		}
		$stmt->close();
		
		$query = "SELECT * FROM permission WHERE email=?";
		$stmt = $con->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows > 0) {
			return new JsonResponse(array('status' => 400, 'message' => "Student has already been invited."));
		}
		$stmt->close();
		
		$query = "INSERT INTO permission (`email`, `key`, `teacher`) VALUES (?,?,?)";
		$stmt = $con->prepare($query);
		$stmt->bind_param('ssi', $email, $key, $teacher);
		
		$result = $stmt->execute();
		
		$result = $stmt->affected_rows > 0;
		
		if($result) {
			
			$stmt = $con->prepare("SELECT email FROM teachers WHERE id=$teacher");
			$result = $stmt->execute();
			$rs = $stmt->get_result();
			$row = $rs->fetch_all(MYSQLI_ASSOC);
			$teach = $row[0]['email'];
			$link = "http://localhost:8000/code/signup"."?key=".$key;

			$mailer = $this->get('swiftmailer.mailer.coding');
			
			$message = $mailer->createMessage()
				->setSubject('You have been invited to join CodingBat C++')
				->setFrom('codingbatcpp@gmail.com')
				->setTo($email)
				->setBody(
					$this->renderView(
					'Emails/registration.html.twig',
					array('teacher' => $teach, 'link' => $link)
					),
					'text/html'
			);
			
			$mailer->send($message);
			
			return new JsonResponse(array('status' => 200, 'message' => "Email sent!"));
		}
		else
			return new JsonResponse(array('status' => 400, 'message' => "Error processing request. Please try again."));
	}
	
	public function progressAction() 
	{
		$id = $_GET['id'];
		
		$con = self::connect();
		
		$query = "SELECT title FROM progress INNER JOIN problems ON problem_id = problems.id WHERE user_id=?";
		$stmt = $con->prepare($query);
		$stmt->bind_param('i',$id);
		$result = $stmt->execute();
		
		$rs = $stmt->get_result();
		$progress = $rs->fetch_all(MYSQLI_ASSOC);
		
		return new JSONResponse($progress);
	}
	
    public function connect()
    {
        return mysqli_connect("localhost","KyleM","Minshall1!", "Site"); //Connect to database
    }
}