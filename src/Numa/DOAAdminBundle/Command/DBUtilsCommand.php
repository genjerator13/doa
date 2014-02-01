<?php

namespace Numa\DOAAdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;

class DBUtilsCommand extends ContainerAwareCommand {

    protected function configure() {
        //php app/console numa:DOA:users admin admin
        $this
                ->setName('numa:dbutil')
                ->setDescription('fix listing fields table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $custom = $em->getConnection()->prepare('SELECT * from listing_field_list_temp');
        $custom->execute();
        $results = $custom->fetchAll();
        foreach ($results as $item) {
            
            $custom = $em->getConnection()->prepare('SELECT * from listing_field WHERE sid='.$item['listing_field_id'].' LIMIT 1');
            $custom->execute();
            $field = $custom->fetch();
            $listing_field=$field['id'];
            $sql = 'insert into listing_field_list set listing_field_id='.$listing_field.' ,value =\''.addslashes($item["value"]).'\',`order` ='.$item["order"];
            $custom = $em->getConnection()->prepare($sql);
            $custom->execute();
            print_r($sql);echo "\n\b ";
        }


    }

}
