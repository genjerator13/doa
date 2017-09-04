<?php

namespace Numa\DOAAdminBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class TestCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('numa:test')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $url = $input->getArgument('param1');

        if ($command == 'test') {
            $this->test($url);
        }
    }

    public function test($url){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FILETIME, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        $info = curl_getinfo($curl);

        if($info['http_code']!=200){
            $email = $this->getContainer()->get('numa.emailer')->sendErrorEmail($url,$info['http_code']);
        }
        curl_close($curl);

    }

}