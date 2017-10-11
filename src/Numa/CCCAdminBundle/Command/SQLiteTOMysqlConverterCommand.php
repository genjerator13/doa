<?php

namespace Numa\CCCAdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\CCCAdminBundle\Entity\Customers;
use Numa\CCCAdminBundle\Entity\Drivers;
use Numa\CCCAdminBundle\Entity\Vehtypes;
use Numa\CCCAdminBundle\Entity\Rates;
use Numa\CCCAdminBundle\Entity\Probills;
use Numa\CCCAdminBundle\Entity\batchX;

class SQLiteTOMysqlConverterCommand extends ContainerAwareCommand {

    public $commandLog;

    protected function configure() {
        $this
                ->setName('Numa:dbc')
                ->addArgument('batchid', InputArgument::OPTIONAL, 'Batch ID')
                ->setDescription('SQLite to MySql converter')
        ;
    }

    private function getSqliteConnection($batchid) {
        $emmysql = $this->getContainer()->get('doctrine')->getManager('default');
        $batch = $emmysql
                ->getRepository('NumaCCCAdminBundle:batchX')
                ->findOneBy(array("id" => $batchid));
        $config = new \Doctrine\DBAL\Configuration();
        $upload = $this->getContainer()->getParameter('upload');
        $dbfile = $upload . $batch->getId() . "/" . $batch->getDbfile();

        if (file_exists($dbfile)) {
            $connectionParams = array(
                'driver' => 'pdo_sqlite',
                'path' => $dbfile,
            );
        }

        $emsqlite = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        return $emsqlite;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->emmysql = $this->getContainer()->get('doctrine')->getManager('default');
        $this->emLog = $this->getContainer()->get('doctrine')->getManager('default');


        $batchid = intval($input->getArgument('batchid'));
        $commandName = "Numa:dbc " . $batchid;

        $existingCommand = $this->emLog->getRepository('NumaCCCAdminBundle:CommandLog')->findCommandRunning($commandName);
        $ok = $existingCommand == null;
        if ($existingCommand instanceof \Numa\CCCAdminBundle\Entity\CommandLog) {
            $ok = $existingCommand->isFinished();
        }

        if ($ok) {
            $this->commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();
            $this->commandLog->setCommand($commandName);
            $this->commandLog->setStartedAt(new \DateTime());
            $this->commandLog->setStatus('started');
            $this->commandLog->setCurrentCustomer(0);
            $this->commandLog->setCurrentProbill(0);
            $this->commandLog->setCurrentDriver(0);
            $this->commandLog->setCurrentRate(0);
            $this->commandLog->setCurrentVehtype(0);



            $this->emsqlite = $this->getSqliteConnection($batchid);

            $this->customers = $this->emsqlite->prepare('SELECT * from Customers');

            $this->customers->execute();

            $this->customersResults = $this->customers->fetchAll();

            //echo "Importing customers total:" . count($this->customersResults) . "\n";

            $this->commandLog->setTotalCustomers(count($this->customersResults));

            $this->drivers = $this->emsqlite->prepare('SELECT * from Drivers');
            $this->drivers->execute();
            $this->driversResults = $this->drivers->fetchAll();
            //echo "Importing drivers total:" . count($this->driversResults) . "\n";
            $this->commandLog->setTotalDrivers(count($this->driversResults));

            $this->vehtypes = $this->emsqlite->prepare('SELECT * from VehTypes');
            $this->vehtypes->execute();
            $this->vehtypesResults = $this->vehtypes->fetchAll();
            //echo "Importing vehicle types total:" . count($this->vehtypesResults) . "\n";
            $this->commandLog->setTotalVehtypes(count($this->vehtypesResults));

            $this->rates = $this->emsqlite->prepare('SELECT * from Rates');
            $this->rates->execute();
            $this->ratesResults = $this->rates->fetchAll();
            //echo "Importing retes types total:" . count($this->ratesResults) . "\n";
            $this->commandLog->setTotalRates(count($this->ratesResults));

            $this->probills = $this->emsqlite->prepare('SELECT * from Probills');
            $this->probills->execute();
            $this->probillsResults = $this->probills->fetchAll();
            //echo "Importing retes probills total:" . count($this->probillsResults) . "\n";
            $this->commandLog->setTotalprobills(count($this->probillsResults));
            $this->emLog->persist($this->commandLog);
            $this->emLog->flush();

            $this->convertCustomers($batchid, $output);
            //echo "Importing drivers \n";
            $this->convertDrivers($batchid, $output);
            $this->convertVehtypes($batchid, $output);
            //echo "Importing Vehicle types \n";
            $this->convertRates($batchid, $output);

            //echo "Importing Rates \n";
            //echo "Importing probills \n";
            //if (!empty($batchid)) {
            //    $this->getProbillsFromUploadedBatch($batchid);
            //} else {
            $this->convertProbills($output, $batchid);
            //}
            $this->commandLog->setStatus('finished');
            $this->commandLog->setEndedAt(new \DateTime());
            $this->emLog->flush();
        } else {
            //echo "COMMAND: " . $commandName . " is still running";
        }
    }

    public function convertCustomers($batchid, $output) {

        $c = 0;
        $existing = 0;
        foreach ($this->customersResults as $key => $customer) {
//check if the customer already exists
            $c++;
            $existingCust = $this->emmysql
                    ->getRepository('NumaCCCAdminBundle:Customers')
                    ->findOneBy(array("custcode" => $customer['CustCode']));

            $newCustomer = new Customers();

            if (!empty($existingCust)) {
                $existing++;
                $newCustomer = $existingCust;
            } else {
                //echo "\n";
            }

            foreach ($customer as $fieldname => $cell) {
                $newCustomer->set($fieldname, $cell);
            }
// encode the password

            if (!empty($existingCust)) {
                //echo "UPDATING:" . $newCustomer->getCustcode() . "\n";
            } else {
                //echo "ADDING:" . $newCustomer->getCustcode() . "\n";
            }


            if ($c % 50 == 0) {
                $this->commandLog->setCurrentCustomer($c);
                $this->emLog->flush();
            }
            $factory = $this->getContainer()->get('security.encoder_factory');
            $encoder = $factory->getEncoder($newCustomer);

            $encodedPassword = $encoder->encodePassword($customer['Password'], $newCustomer->getSalt());
            $newCustomer->setPassword($encodedPassword);
            $this->emmysql->persist($newCustomer);
        }
        $this->commandLog->setCurrentCustomer($c);
        $this->emLog->flush();
        $this->emmysql->flush();
        $this->emLog->flush();
        $output->writeln(sprintf('Customers has been imported from s3db'));
        $output->writeln(sprintf('Total Customers:' . count($this->customersResults) . " Existing (updated):" . $existing));
    }

    public function convertDrivers($batchid, $output) {

        $factory = $this->getContainer()->get('security.encoder_factory');
        $c = 0;
        foreach ($this->driversResults as $key => $driver) {
            $c++;
            $existingdriver = $this->emmysql
                    ->getRepository('NumaCCCAdminBundle:Drivers')
                    ->findOneBy(array("drivernum" => $driver['DriverNum']));


            $newDriver = $existingdriver;
            if (empty($existingdriver)) {
                $newDriver = new Drivers();
            }
            if (!empty($existingdriver)) {
                //echo "UPDATING:" . $newDriver->getDrivernum() . "\n";
            } else {
                //echo "ADDING:" . $newDriver->getDrivernum() . "\n";
            }
            foreach ($driver as $fieldname => $cell) {
                $newDriver->set($fieldname, $cell);
            }

            if ($c % 50 == 0) {
                $this->commandLog->setCurrentDriver($c);
                $this->emLog->flush();
            }

            $this->emmysql->persist($newDriver);
        }
        $this->commandLog->setCurrentDriver($c);
        $this->emLog->flush();
        $this->emmysql->flush();
        $this->emLog->flush();
        $output->writeln(sprintf('Drivers has been imported from s3db'));
    }

    public function convertVehtypes($batchid, $output) {

        $factory = $this->getContainer()->get('security.encoder_factory');

        $c = 0;
        foreach ($this->vehtypesResults as $key => $veh) {
            $c++;
            $existingveh = $this->emmysql
                    ->getRepository('NumaCCCAdminBundle:Vehtypes')
                    ->findOneBy(array("vehcode" => $veh['vehcode']));

            $newVeh = $existingveh;
            if (empty($existingveh)) {

                $newVeh = new Vehtypes();
            }

            foreach ($veh as $fieldname => $cell) {

                $newVeh->set($fieldname, $cell);
            }

            if ($c % 50 == 0) {
                $this->commandLog->setCurrentVehtype($c);
                $this->emLog->flush();
            }
            $this->emmysql->persist($newVeh);
        }
        $this->commandLog->setCurrentVehtype($c);
        $this->emmysql->flush();
        $this->emLog->flush();
        $output->writeln(sprintf('Vehcle types has been imported from s3db'));
    }

    public function convertRates($batchid, $output) {
        $c = 0;
        foreach ($this->ratesResults as $key => $rate) {
            $c++;
            $existingrate = $this->emmysql
                    ->getRepository('NumaCCCAdminBundle:Rates')
                    ->findOneBy(array("rateCode" => $rate['Rate_Code']));

            $newRate = $existingrate;
            if (empty($existingrate)) {
                $newRate = new Rates();
            }

            foreach ($rate as $fieldname => $cell) {
                $newRate->set($fieldname, $cell);
            }
            if ($c % 50 == 0) {

                $this->commandLog->setCurrentRate($c);
                $this->emLog->flush();
            }

            $this->emmysql->persist($newRate);
        }
        $this->commandLog->setCurrentRate($c);
        $this->emLog->flush();
        $this->emmysql->flush();
        $output->writeln(sprintf('Rates types has been imported from s3db'));
    }

    public function convertProbills($output, $batchid) {

        $c = 0;
        $logger = $this->getContainer()->get('logger');
        foreach ($this->probillsResults as $key => $probill) {

            $c++;

            $existingprobill = $this->emmysql
                    ->getRepository('NumaCCCAdminBundle:Probills')
                    ->findOneBy(array("createdAt" => $probill['created_at'], "waybill" => $probill['WayBill'], "subitem" => $probill['SubItem']));

            $newProbills = $existingprobill;
            if (empty($existingprobill)) {
                $newProbills = new Probills();
            }

            foreach ($probill as $fieldname => $cell) {
                $newProbills->set($fieldname, $cell);
            }


            $logger->warning("probill waybill: ".$c." :".$newProbills->getWaybill());
            //relations
            $custRepo = $this->emmysql->getRepository('NumaCCCAdminBundle:Customers');
            $customer = $custRepo->findOneBy(array('custcode' => $newProbills->getCustomerCode()));
            $newProbills->setCustomers($customer);
            $logger->warning("probillsetCustomers: ".$c." :");
            $driverRepo = $this->emmysql->getRepository('NumaCCCAdminBundle:Drivers');

            $driver = $driverRepo->findOneBy(array('drivernum' => $newProbills->getDriverId()));

            $newProbills->setDrivers($driver);
            $logger->warning("probill setDrivers: ".$c." :");
            $rateRepo = $this->emmysql->getRepository('NumaCCCAdminBundle:Rates');
            $rate = $rateRepo->findOneBy(array('rateCode' => $newProbills->getRateCode()));

            $newProbills->setRates($rate);
            $logger->warning("probill setRates: ".$c." :");

            $vehtypesRepo = $this->emmysql->getRepository('NumaCCCAdminBundle:Vehtypes');
            $vehtype = $vehtypesRepo->findOneBy(array('vehcode' => $newProbills->getVehcode()));
            $newProbills->setVehtypes($vehtype);
            $logger->warning("probill setVehtypes: ".$c." :");

            $batchxRepo = $this->emmysql->getRepository('NumaCCCAdminBundle:batchx');
            $batchX = $batchxRepo->findOneBy(array('id' => $batchid));
            $newProbills->setBatchX($batchX);
            $logger->warning("probill setBatchX: ".$c." :");




            $this->emmysql->persist($newProbills);
            $logger->warning("after persists probills to DB: ".$c." :".memory_get_usage());

            if ($c % 500 == 0) {
                $this->commandLog->setCurrentProbill($c);
                $this->emmysql->flush();

                $logger->warning("saving probills to DB: ".$c." :");
            }

//$emmysql->flush();
        }
        $this->commandLog->setCurrentProbill($c);
        $this->emLog->flush();
        $this->emmysql->flush();
        //delete all pending probills
        $qb = $this->emmysql->createQueryBuilder();
        $qb->delete('NumaCCCAdminBundle:PendingProbill', 'p');
        $qb->getQuery()->execute();
        $output->writeln(sprintf('Probills types has been imported from s3db'));
        $logger->warning("END:  :");
    }

    public function getProbillsFromUploadedBatch($id) {
        //echo memory_get_usage() . ":1:" . "\n";

        $emmysql = $this->getContainer()->get('doctrine')->getManager('default');
        $emmysql->getConnection()->getConfiguration()->setSQLLogger(null);
        $config = new \Doctrine\DBAL\Configuration();
        //$this->getContainer()->get('profiler')->disable();
        //echo $id;
        $batch = $emmysql
                ->getRepository('NumaCCCAdminBundle:batchX')
                ->findOneBy(array("id" => $id));

        $upload = $this->getContainer()->getParameter('upload');
        $dbfile = $upload . $batch->getId() . "/" . $batch->getDbfile();
        $countExisting = 0;
        $countNew = 0;
        //echo memory_get_usage() . ":2:" . "\n";        
        //echo $dbfile;        
        if (file_exists($dbfile)) {
            $connectionParams = array(
                'driver' => 'pdo_sqlite',
                'path' => $dbfile,
            );
            $limit = 1000;
            $offset = 0;
            $emsqlite2 = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
            $q = 'SELECT count(*) as count from Probills';
            $count = $emsqlite2->prepare($q);
            $count->execute();
            $results = $count->fetchAll();

            //progress

            $progress = array();
            $progress['count'] = $results[0]['count'];


            //print_r($results);echo "\n";
            //echo memory_get_usage() . ":3:" . "/n";
            $current = 0;
            do {



                //echo memory_get_usage() . ":1:" . "\n";
                $emmysql = $this->getContainer()->get('doctrine')->getManager('default');
                //echo memory_get_usage() . ":2:" . "\n";
                $emsqlite = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
                //echo memory_get_usage() . ":3:" . "\n";
                $q = 'SELECT * from Probills LIMIT ' . $limit . " OFFSET " . $offset;
                $probills = $emsqlite->prepare($q);
                //echo memory_get_usage() . ":4:" . "\n" . $q . "\n";
                $offset = $offset + $limit;
                //echo memory_get_usage() . ":5:" . "\n";
                $probills->execute();
                //echo memory_get_usage() . ":6:" . "\n";
                //87775700
                //219916752

                $results = $probills->fetchAll();
                unset($probills);
                $count = count($results);
                if ($count > 0) {

                    foreach ($results as $key => $probill) {

                        $existingprobill = $emmysql
                                ->getRepository('NumaCCCAdminBundle:Probills')
                                ->findOneBy(array("createdAt" => $probill['created_at'], "waybill" => $probill['WayBill'], 'batchId' => $id));

                        $newProbills = $existingprobill;
                        if (empty($existingprobill)) {
                            $newProbills = new Probills();
                            $countNew++;
                        } else {
                            $countExisting++;
                        }

                        foreach ($probill as $fieldname => $cell) {
                            $newProbills->set($fieldname, $cell);
                        }

                        $custRepo = $emmysql->getRepository('NumaCCCAdminBundle:Customers');
                        $customer = $custRepo->findOneBy(array('custcode' => $newProbills->getCustomerCode()));
                        $newProbills->setCustomers($customer);

                        $driverRepo = $emmysql->getRepository('NumaCCCAdminBundle:Drivers');
                        $driver = $driverRepo->findOneBy(array('drivernum' => $newProbills->getDriverCode()));
                        $newProbills->setDrivers($driver);

                        $rateRepo = $emmysql->getRepository('NumaCCCAdminBundle:Rates');
                        $rate = $rateRepo->findOneBy(array('rateCode' => $newProbills->getRateCode()));
                        $newProbills->setRates($rate);

                        $vehtypesRepo = $emmysql->getRepository('NumaCCCAdminBundle:Vehtypes');
                        $vehtype = $vehtypesRepo->findOneBy(array('vehcode' => $newProbills->getVehcode()));
                        $newProbills->setVehtypes($vehtype);

                        $batchxRepo = $emmysql->getRepository('NumaCCCAdminBundle:batchx');
                        $batchX = $batchxRepo->findOneBy(array('id' => $id));
                        $newProbills->setBatchX($batchX);
                        $current++;
                        $emmysql->persist($newProbills);
                        unset($custRepo);
                        unset($driverRepo);
                        unset($rateRepo);
                        unset($vehtypesRepo);
                        unset($batchxRepo);
                        unset($customer);
                        unset($driver);
                        unset($rate);
                        unset($vehtype);
                        unset($batchX);
                        unset($newProbills);
                        unset($existingprobill);
                        unset($probills);

                        if ($current % 50 == 0 || $count - $current < 50) {
                            $progress["current"] = $current;

                            $fp = fopen($this->getContainer()->getParameter('log') . "progress_" . $id . ".txt", 'w');
                            //die("aaaa");
                            fwrite($fp, json_encode($progress));
                            fclose($fp);
                        }
                    }
                }
                //echo memory_get_usage() . ":7:" . "\n";
                $emmysql->flush();
                //echo memory_get_usage() . ":8:" . "\n";
                $emmysql->clear();
                //echo memory_get_usage() . ":9:" . "\n";
                unset($results);
                //echo memory_get_usage() . ":11:" . "\n";
                unset($emmysql);
                //echo memory_get_usage() . ":12:" . "\n";
                unset($emsqlite);
            } while ($count > 0);
        }
        //echo "New Probills inserted: " . $countNew . " ;Existing probills updated: " . $countExisting;
        //495297568:5:
//495304200:6:
//495296440:7:
//495296440:8:
//495296440:9:
//495296276:11:
//495296276:12:
//4952962766
//67314948:7:
        //echo memory_get_usage() . "6" . "\n";
    }

}
