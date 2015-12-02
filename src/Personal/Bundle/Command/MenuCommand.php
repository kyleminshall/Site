<?php

namespace Personal\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\BufferedOutput;

class MenuCommand extends ContainerAwareCommand
{   
    protected function configure()
    {
        $this
            ->setName('personal:menu')
            ->setDescription('Send out an email of the menu')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {      
        $con = mysqli_connect('localhost', 'KyleM', 'Minshall1!', 'Site');
        
        if(mysqli_connect_errno()) {
            printf("Connect failed: $s\n", mysqli_connect_error());
            exit();
        }
        
        $query = "SELECT email FROM lists WHERE hall=1 OR hall=3 OR hall=13";
        
        $result = mysqli_query($con, $query);
        
        $jsonData = array();
        while($array = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $jsonData[] = $array[0];
        }
        
        $param = escapeshellarg(json_encode($jsonData));
        $final = shell_exec('/usr/local/bin/python /Users/Kilenaitor/Desktop/Site/personal/src/Personal/Bundle/Resources/public/lothian.py ' . $param);
        
        error_log($final);
        
        $query = "SELECT email FROM lists WHERE hall=2 OR hall=3 OR hall=13";
        
        $result = mysqli_query($con, $query);
        
        $jsonData = array();
        while($array = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $jsonData[] = $array[0];
        }
        
        $param = escapeshellarg(json_encode($jsonData));
        $final = shell_exec('/usr/local/bin/python /Users/Kilenaitor/Desktop/Site/personal/src/Personal/Bundle/Resources/public/ai.py ' . $param);
        
        error_log($final);
        
        $query = "SELECT email FROM lists WHERE hall=10 OR hall=13";
        
        $result = mysqli_query($con, $query);
        
        $jsonData = array();
        while($array = mysqli_fetch_array($result, MYSQLI_NUM))
        {
            $jsonData[] = $array[0];
        }
        
        $param = escapeshellarg(json_encode($jsonData));
        $final = shell_exec('/usr/local/bin/python /Users/Kilenaitor/Desktop/Site/personal/src/Personal/Bundle/Resources/public/market.py ' . $param);
        
        error_log($final);
    }
}
