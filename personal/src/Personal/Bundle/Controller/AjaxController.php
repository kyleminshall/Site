<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Util\SecureRandom;

class AjaxController extends Controller
{
	public function addStudentAction()
	{
		$generator = new SecureRandom();
		$random = $generator->nextBytes(20);
		
		$email = $_POST['email'];
		$key = $random;
		$teacher = $_POST['id'];
		
		$con = self::connect();
		
		$query = "INSERT INTO permission (`email`, `key`, `teacher`) VALUES (?,?,?)";
		$stmt = $con->prepare($query);
		$stmt->bind_param('s',$email);
		$stmt->bind_param('s',$key);
		$stmt->bind_param('i', $teacher);
		
		$result = $stmt->execute();
		
		$result = $stmt->affected_rows > 0;
		
		if($result) {
			
			$stmt = $con->prepare("SELECT email FROM teachers WHERE id=$teacher");
			$result = $stmt->execute();
			$rs = $stmt->get_result();
			$row = $rs->fetch_all(MYSQLI_ASSOC);
			$teach = $row[0]['email'];

			$mailer = $this->get('swiftmailer.mailer.coding');
			
			$message = $mailer->createMessage()
				->setSubject('You have been invited to join CodingBat C++')
				->setFrom('CodingBat C++' => 'codingbatcpp@gmail.com')
				->setTo($email)
				->setBody(
					$this->renderView(
					'Emails/registration.html.twig',
					array('teacher' => $teach)
					),
					'text/html'
			);
			
			$mailer->send($message);
			
			return new JsonResponse(array('status' => 200, 'message' => "success"));
		}
		else
			return new JsonResponse(array('status' => 400, 'message' => "failure"));
	}
	
    public function connect()
    {
        return mysqli_connect("localhost","KyleM","Minshall1!", "Site"); //Connect to database
    }
}