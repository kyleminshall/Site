<?php

namespace Picks\PickBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PickBundle\Entity\Picks;

class MailCommand extends ContainerAwareCommand
{   
    protected function configure()
    {
        $this
            ->setName('picks:mail')
            ->setDescription('Send out an email to everyone with the results')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {      
        $command = $this->getApplication()->find('picks:check');

        $returnCode = $command->run($input, $output);
        
        if($returnCode == 0)
        {
            $em = $this->getContainer()->get('doctrine')->getManager();
            $connection = $em->getConnection();
            $statement = $connection->prepare("SELECT email, choices FROM picks");
            $statement->execute();
            $results = $statement->fetchAll();            
            
            $temp = "";
            
            foreach($results as $result)
            {
                $temp = $temp.$result['email']." chose ".$result['choices']."\n\n";
            } 

            $body = $temp;
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Pick Results')
                    ->setFrom(array('kilenaitor@gmail.com' => 'Kyle Minshall'))
                    ->setTo(array('kyleminshall@gmail.com' => 'Kyle Minshall', 'kilenaitor@gmail.com' => 'Scott Minshall'))
                    ->setBody($body)
            ;
            
            
            $result = $this->getContainer()->get('mailer')->send($message);
            
            $output->writeln($body);
            
            $statement = $connection->prepare("UPDATE users SET notified=1");
            $statement->execute();
        }
    }
}
