<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\CommandLog;

class UtilsLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    /**
     * Ealsticksearch populate.
     *
     */
    public function populateElasticSearch()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $lastCommand = $em->getRepository("NumaDOAAdminBundle:CommandLog")->findOneBy(array('category' => "elasticsearch"), array('id' => 'desc'));

        if ($lastCommand instanceof CommandLog) {
            if ($lastCommand->isRunning()) {
                die();
            }
        }
        $command = 'php ' . $this->container->get('kernel')->getRootDir() . '/console fos:elastica:populate';
        $commandDesc = 'php app/console fos:elastica:populate';
        $commandLog = new CommandLog();
        $commandLog->setCategory('elasticsearch');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand($commandDesc);
        $em->persist($commandLog);
        $em->flush();
        $process = new \Symfony\Component\Process\Process($command);
        $process->start();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
        return true;
    }

    /**
     * Ealsticksearch start service.
     *
     */
    public function startElasticSearchService()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $lastCommand = $em->getRepository("NumaDOAAdminBundle:CommandLog")->findOneBy(array('category' => "elasticsearch"), array('id' => 'desc'));

        if ($lastCommand instanceof CommandLog) {
            if ($lastCommand->isRunning()) {
                die();
            }
        }
        $command = 'sudo service elasticsearch start';
        $commandDesc = 'starting elasticsearch service';
        $commandLog = new CommandLog();
        $commandLog->setCategory('elasticsearch');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand($commandDesc);
        $em->persist($commandLog);
        $em->flush();
        dump(exec($command));die();
//        $process = new \Symfony\Component\Process\Process($command);
//        $process->run();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
        return true;
    }

    /**
     * Ealsticksearch populate.
     *
     */
    public function kijiji($dealer = null)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
//        $lastCommand = $em->getRepository("NumaDOAAdminBundle:CommandLog")->findOneBy(array('category' => "kijiji"), array('id' => 'desc'));
//
//        if ($lastCommand instanceof CommandLog) {
//            if ($lastCommand->isRunning()) {
//                die();
//            }
//        }
        $sufix = "kijiji_all";
        if ($dealer instanceof Catalogrecords) {
            $sufix = "kijiji " . $dealer->getId();
        }

        $command = 'php ' . $this->container->get('kernel')->getRootDir() . '/console numa:dbutil ' . $sufix;
        $commandDesc = 'php app/console numa:dbutil ' . $sufix;
        $commandLog = new CommandLog();
        $commandLog->setCategory('kijiji');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand($commandDesc);
        $em->persist($commandLog);
        $em->flush();
        $process = new \Symfony\Component\Process\Process($command);
        $process->start();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
        return true;
    }
}