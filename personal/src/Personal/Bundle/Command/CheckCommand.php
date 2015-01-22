<?php

namespace Personal\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Bundle\Entity\Users;

class CheckCommand extends ContainerAwareCommand
{   
    protected function configure()
    {
        $this
            ->setName('personal:check')
            ->setDescription('Check if everyone has picked')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM users WHERE picked = 1 AND notified = 0");
        $statement->execute();
        $results = $statement->fetchAll();  
        if(count($results) >= 3)
        {
            $output->writeln(1);
        } else {
            $output->writeln(2);
        }
    }
}
