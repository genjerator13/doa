<?php

namespace Numa\DOAAdminBundle\Command;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\NotNull;

class UsersCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('numa:user')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1')
            ->addArgument('param2', InputArgument::OPTIONAL, 'param2');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $csvPath = $input->getArgument('param1');
        $dealer_id  = $input->getArgument('param2');

        if ($command == 'csv') {
            $this->importFromCsv($csvPath,$dealer_id);
        }
    }

    public function importFromCsv($csvPath, $dealer_id)
    {
        $em = $this->getContainer()->get("doctrine.orm.default_entity_manager");
        $csv = array_map('str_getcsv', file($csvPath));
        $i=0;

        foreach ($csv as $key=>$row) {
            if($i>1){

                $customer = $em->getRepository(Customer::class)->findOneBy(array("name"=>$row[0]));
                $dealer = $em->getRepository(Catalogrecords::class)->find($dealer_id);
                if(!$dealer instanceof Catalogrecords){
                    dump("NOT A DEALER");
                }
                if(!($customer instanceof Customer)){
                    $customer=new Customer();
                    $em->persist($customer);
                }
                $customer->setDealer($dealer);
                $customer->setName($row[0]);
                $customer->setAddress($row[1]);
                $customer->setCity($row[2]);
                $customer->setState($row[3]);
                $customer->setZip($row[4]);
                //if email
                if(filter_var($row[5], FILTER_VALIDATE_EMAIL)) {
                    $customer->setEmail($row[5]);
                }

                ///
                $customer->setHomePhone($row[6]);
                $customer->setMobilePhone($row[7]);
                $customer->setFax($row[8]);
            }
            $i++;
            if($i%50==0){
                dump($i);
                $em->flush();
            }
        }
        $em->flush();
    }

}