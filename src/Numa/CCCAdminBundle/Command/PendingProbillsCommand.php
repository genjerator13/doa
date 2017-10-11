<?php
namespace Numa\CCCAdminBundle\Command;

use Numa\CCCAdminBundle\Entity\PendingProbill;
use Numa\CCCAdminBundle\Entity\Probills;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;

class PendingProbillsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        //php app/console numa:DOA:users admin admin
        $this
            ->setName('Numa:CCC:pending')
            ->setDescription('Import pending probills')
            ->addArgument('action', InputArgument::REQUIRED, 'action')
            ->addArgument('filename', InputArgument::REQUIRED, 'pendingFilename');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $action = $input->getArgument('action');
        $pendingFilename = $input->getArgument('filename');
        if ($action == "insert") {
            $this->insertPendingProbills($output, $pendingFilename);
        }

    }

    private function getSqliteConnection($pendingFile = "")
    {
        $config = new \Doctrine\DBAL\Configuration();
        if (!empty($pendingFile)) {
            $pendingUpload = $this->getContainer()->getParameter('pending');
            $dbfile = $pendingUpload . $pendingFile;
        }
        $connectionParams = array(
            'driver' => 'pdo_sqlite',
            'path' => $dbfile,
        );


        $emsqlite = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        return $emsqlite;
    }

    public function insertPendingProbills($output, $pendingFilename)
    {

        $c = 0;
        $emmysql = $this->getContainer()->get('doctrine')->getManager('default');
        $emsqlite = $this->getSqliteConnection($pendingFilename);
        $pendings = $emsqlite->prepare('SELECT * from Probills');
        $pendings->execute();
        $pendingResults = $pendings->fetchAll();
        //dump(count($pendingResults));die();
        //delete all pending probills
        //$qb = $emmysql->createQueryBuilder();
        //$qb->delete('NumaCCCAdminBundle:PendingProbill', 'p');
        //$qb->getQuery()->execute();

        $commandLog = new \Numa\CCCAdminBundle\Entity\CommandLog();
        $commandLog->setCommand("numa:CCC:pending insert ".$pendingFilename);
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCurrentProbill(0);
        $commandLog->setTotal(count($pendingResults));
        $commandLog->setTotalProbills(count($pendingResults));
        $emmysql->persist($commandLog);
        $emmysql->flush();
        $count = count($pendingResults);
        $progress=array();
        $progress["total"] = $count;
        foreach ($pendingResults as $key => $probill) {
            $c++;

            $pendingProbill = new PendingProbill();

            foreach ($probill as $fieldname => $cell) {
                $pendingProbill->set($fieldname, $cell);
            }
            //relations
            $custRepo = $emmysql->getRepository('NumaCCCAdminBundle:Customers');
            $customer = $custRepo->findOneBy(array('custcode' => $pendingProbill->getCustomerCode()));
            $pendingProbill->setCustomers($customer);

            $driverRepo = $emmysql->getRepository('NumaCCCAdminBundle:Drivers');
            $driver = $driverRepo->findOneBy(array('drivernum' => $pendingProbill->getDriverCode()));
            $pendingProbill->setDrivers($driver);

            $rateRepo = $emmysql->getRepository('NumaCCCAdminBundle:Rates');
            $rate = $rateRepo->findOneBy(array('rateCode' => $pendingProbill->getRateCode()));
            $pendingProbill->setRates($rate);

            $vehtypesRepo = $emmysql->getRepository('NumaCCCAdminBundle:Vehtypes');
            $vehtype = $vehtypesRepo->findOneBy(array('vehcode' => $pendingProbill->getVehcode()));
            $pendingProbill->setVehtypes($vehtype);

            $emmysql->persist($pendingProbill);

            $commandLog->setCurrentProbill($c);
            $emmysql->flush();
            
        }
        $commandLog->setStatus('finished');
        $emmysql->flush();
        $output->writeln(sprintf('Pending Probills has been imported from s3db'));
    }
}
