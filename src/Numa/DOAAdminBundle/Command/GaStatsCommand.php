<?php

namespace Numa\DOAAdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class GaStatsCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        //set_error_handler( array( $this, 'myErrorHandler' ) );
        $this
            ->setName('numa:stats')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1')
            ->addArgument('param2', InputArgument::OPTIONAL, 'param2');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');
        $param2 = $input->getArgument('param2');

        if ($command == 'gastats') {
            $this->GaStats($param1, $param2);
        }
    }

    public function GaStats($param1, $param2)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        if (empty($param2)) {
            $todaysDate = new \DateTime('today');
            $param2 = $todaysDate->format("Y-m-d");
        }

        if ($param1 === "all") {
            $dealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
            foreach($dealers as $dealer){
                if(!empty($dealer->getSettingGaView())){
                    $this->getContainer()->get('Numa.Stats.GaStats')->GaStats($dealer, $param2);
                }
            }
        } else{
            $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($param1);
            if(!empty($dealer->getSettingGaView())){
                $this->getContainer()->get('Numa.Stats.GaStats')->GaStats($dealer, $param2);
            }
        }
    }
}