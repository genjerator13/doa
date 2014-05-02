<?php

namespace Numa\DOAAdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;
use Numa\DOAAdminBundle\Entity\HomeTab;

class DBUtilsCommand extends ContainerAwareCommand {

    protected function configure() {
        //php app/console numa:DOA:users admin admin
        $this
                ->setName('numa:dbutil')
                ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
                ->setDescription('fix listing fields table')
        ;
    }

    function makeListingFromTemp() {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $custom = $em->getConnection()->prepare('SELECT * from listing_field_list_temp');
        $custom->execute();
        $results = $custom->fetchAll();
        foreach ($results as $item) {

            $custom = $em->getConnection()->prepare('SELECT * from listing_field WHERE sid=' . $item['listing_field_id'] . ' LIMIT 1');
            $custom->execute();
            $field = $custom->fetch();
            $listing_field = $field['id'];
            $sql = 'insert into listing_field_list set listing_field_id=' . $listing_field . ' ,value =\'' . addslashes($item["value"]) . '\',`order` =' . $item["order"];
            $custom = $em->getConnection()->prepare($sql);
            $custom->execute();
            print_r($sql);
            echo "\n\b ";
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $command = $input->getArgument('function');
        if ($command == 'makelistfromtemp') {
            $this->makeListingFromTemp();
        } elseif ($command == 'hometabs') {
            $this->makeHomeTabs();
        }
    }

    /**
     * Creates array for tabs on homepage
     */
    function makeHomeTabs() {
        print_r("Making home tabs");
        $aCategories = array(1, 2, 3, 4);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $categories = $em->getRepository('NumaDOAAdminBundle:Category')->findAll();
        $tabs = array();
        //remove old hometabs
        $oldHometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
        foreach($oldHometabs as $hometab){
            $em->remove($hometab);
        }
        foreach ($categories as $cat) {

            $list = "";
            if ($cat->getId() == 2) {
                //Marine
                $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByCaption('Boat Type');
                if (!empty($subCat)) {

                    $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                    foreach ($list as $key => $value) {
                        $items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(),'field_integer_value'=>$value->getId()));
                        $count = count($items);
                        print_r(count($items));echo ":".$subCat->getId().":".$value->getId()."\n";
                        //$count = $items->count();
                        $hometab = new HomeTab();
                        $hometab->setCategoryId($cat->getId());
                        $hometab->setCategoryName($cat->getName());
                        $hometab->setListingFieldLists($value);
                        $hometab->setListingFieldListValue($value->getValue());
                        $hometab->setCount($count);
                        $em->persist($hometab);
                        //print_r($key);
                    }
                    $em->flush();
                }
            }else if ($cat->getId() == 4) {
                //RV
                $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption'=>'Type','category_sid'=>$cat->getId()));
                if (!empty($subCat)) {

                    $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                    foreach ($list as $key => $value) {
                        $items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(),'field_integer_value'=>$value->getId()));
                        $count = count($items);
                        //print_r(count($items));echo ":".$subCat->getId().":".$value->getId()."\n";
                        //$count = $items->count();
                        $hometab = new HomeTab();
                        $hometab->setCategoryId($cat->getId());
                        $hometab->setCategoryName($cat->getName());
                        $hometab->setListingFieldLists($value);
                        $hometab->setListingFieldListValue($value->getValue());
                        $hometab->setCount($count);
                        $em->persist($hometab);
                        //print_r($key);
                    }
                    $em->flush();
                }
            }
        }
    }

}
