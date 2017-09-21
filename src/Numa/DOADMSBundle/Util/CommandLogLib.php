<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\CommandLog;

class CommandLogLib
{
    use containerTrait;

    public function startNewCommand($command, $category, $dealer = null)
    {
        $em = $this->container->get('doctrine')->getManager();

        $commandLog = new CommandLog();
        $commandLog->setCategory($category);
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand($command);
        $commandLog->setDealer($dealer);
        $em->persist($commandLog);
        $em->flush();
        return $commandLog;
    }

    public function endCommand(CommandLog $commandLog)
    {
        $em = $this->container->get('doctrine')->getManager();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
    }

    public function append(CommandLog $commandLog, $string)
    {
        $commandLog->appendFullDetails($string);
        return $commandLog;
    }
}