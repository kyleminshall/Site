<?php

namespace Picks\PickBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PickBundle\Entity\Picks;

class CheckCommand extends ContainerAwareCommand
{   
    protected function configure()
    {
        $this
            ->setName('picks:check')
            ->setDescription('Check if everyone has picked')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM users WHERE picked = 1");
        $statement->execute();
        $results = $statement->fetchAll();
        if(count($results) == 3)
        {
            echo "True\n";
        } else {
            echo "False\n";
        }
    }
}
