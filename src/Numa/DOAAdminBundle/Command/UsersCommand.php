<?php

namespace Numa\DOAAdminBundle\Command;


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
            ->addArgument('param1', InputArgument::OPTIONAL, 'param1');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $param1 = $input->getArgument('param1');

        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($command == 'archive') {
            $this->archive($param1);
        }
        elseif ($command == 'sold') {
            $this->setSoldDate();
        }
    }

    public function importFromCsv()
    {
        $em = $this->getDoctrine()->getManager();
        $csv = array_map('str_getcsv', file('/var/www/cbc/clients.csv'));

        $i=0;

        $header=array();
        foreach ($csv as $key=>$row) {
            if($i==0){
                $header=$row;
            }else{
                $customer = $em->getRepository(Customer::class)->findOneBy(array("clientNum"=>$row[2]));

                if(!($customer instanceof Customer)){
                    $customer=new Customer();
                    $customer->setEmail(time()+$i."");

                    $em->persist($customer);
                    //dump($i."user NOT exists");
                }
                $user->setActive(true);
                $user->setEnabled(true);
                $user->setClientOldId($row[0]);
                $user->setName($row[1]);
                $user->setClientNum($row[2]);
                $user->setAddress($row[3]);
                $user->setPhone($row[4]);
                $user->setCity($row[5]);
                $user->setPostalCode($row[6]);
                $user->setFax($row[7]);

                $user->setContactPerson($row[9]);
                $user->setUsername($row[2]);
                $user->setUsernameCanonical($row[2]);
                $pass=$row[11];
                if(empty($pass)) {
                    $pass="empty";
                }
                $user->setPlainPassword($pass);

                $user->setUserGroup($usergroup);
                //dump($user);
                $userupdater = $this->get("fos_user.util.password_updater")->hashPassword($user);
                //dump($user);
                $em->flush($user);
//die();


            }

            $i++;

        }



        die("finished importing ".$i);
    }

}