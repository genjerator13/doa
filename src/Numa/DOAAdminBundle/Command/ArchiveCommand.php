<?php

namespace Numa\DOAAdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class ArchiveCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        //set_error_handler( array( $this, 'myErrorHandler' ) );
        $this
            ->setName('numa:archive')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');

        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($command == 'archive') {
            $this->archive();
        }
    }

    public function archive(){

        $em = $this->getContainer()->get('doctrine')->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findArchived();
        foreach($items as $item){
            $item->setArchiveStatus('archived');
            $em->flush();
        }
        dump(count($items));
    }

}