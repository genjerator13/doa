<?php

namespace Numa\DOAAdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\User;
use Numa\DOAAdminBundle\Entity\HomeTab;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Importmapping;
use Numa\DOAAdminBundle\Entity\Importmappings;
use Numa\DOAAdminBundle\Form\ImportmappingType;
use Numa\DOAAdminBundle\Form\ImportmappingRowType;
use Numa\DOAAdminBundle\Lib\RemoteFeed;
use Numa\DOAAdminBundle\Entity\CommandLog;

class DBUtilsCommand extends ContainerAwareCommand {

    protected function configure() {
        //php app/console numa:DOA:users admin admin
        //set_error_handler( array( $this, 'handler' ) );
        $this
                ->setName('numa:dbutil')
                ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
                ->addArgument('feed_id', InputArgument::OPTIONAL, 'feed id')
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
        $feed_id = $input->getArgument('feed_id');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $em->clear();
        if ($command == 'makelistfromtemp') {
            $this->makeListingFromTemp();
        } elseif ($command == 'hometabs') {
            $this->makeHomeTabs();
        } elseif ($command == 'equalize') {
            $this->equalizeAllItems();
        } elseif ($command == 'fetchFeed') {
            $this->fetchFeed($feed_id, $em);
        } elseif ($command == 'startCommand') {
            $this->startCommand($em);
        }
    }

    public function startCommand($em) {
        $emlog = $this->getContainer()->get('doctrine')->getManager();
        $commands = $em->getRepository('NumaDOAAdminBundle:CommandLog')->findBy(array('status' => 'pending'));

        foreach ($commands as $command) {
            $commandSplit = explode(" ", $command->getCommand());
            $feedId = end($commandSplit);
            $commandDB = $emlog->getRepository('NumaDOAAdminBundle:CommandLog')->find($command->getId());
            $commandDB->setStatus("Executed");
            $emlog->flush();
            $this->fetchFeed($feedId, $em);
        }
        //echo "aaaaa";
        //die();
    }

    public function fetchFeed2($feed_id) {

        $Controller = new \Numa\DOAAdminBundle\Controller\ImportmappingController();

        $Controller->fetchAction(null, $feed_id);
        //print_r($feed_id);
        //die("aaaaa");
    }

    function myErrorHandler($errno, $errstr, $errfile, $errline) {
        $this->commandLog->setStatus("ERROR");
        $this->commandLog->setFullDetails("Error: [$errno] $errstr<br />$errfile : $errline\n");
        $this->em->flush();
        $this->em->clear();

        exit(1);
        return true;
    }

    public function fetchFeed($id, $em) {
        try {
            $this->em = $em;
            set_error_handler(array($this, "myErrorHandler"));
            $conn = $em->getConnection();

            $this->commandLog = new CommandLog();
            $this->commandLog->setCategory('fetch');
            $this->commandLog->setStartedAt(new \DateTime());
            $this->commandLog->setStatus('started');

            $this->commandLog->setCommand($this->getName() . " fetchFeed " . $id);
            $this->em->persist($this->commandLog);
            $this->em->flush();


            $createdItems = array();
            $feed_id = $id;
            $remoteFeed = new Remotefeed($id);
            $items = $remoteFeed->getRemoteItems();

            $sql = 'update command_log set count=' . count($items) . " where id=" . $this->commandLog->getId();
            $num_rows_effected = $conn->exec($sql);

            //print items
            //

            
            unset($remoteFeed);

            $mapping = $this->em->getRepository('NumaDOAAdminBundle:Importmapping')->findBy(array('feed_sid' => $feed_id));
            $sold = $this->em->getRepository('NumaDOAAdminBundle:Item')->setSoldOnAllItemInFeed($feed_id);

            $upload_url = $this->getContainer()->getParameter('upload_url');
            $upload_path = $this->getContainer()->getParameter('upload_path');

            //echo "Memory usage in fetchAction inside1: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
            $count = 0;

            foreach ($items as $importItem) {

                $item = $this->em->getRepository('NumaDOAAdminBundle:Item')->importRemoteItem($importItem, $mapping, $feed_id, $upload_url, $upload_path, $em);
                if (!empty($item)) {
                    $createdItems[] = $item;
                }

                unset($item);
                //echo "Memory usage in fetchAction inloop: " . $count . "::" . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
                $count++;
                if ($count % 500 == 0) {
                    $this->commandLog->setFullDetails($this->makeDetailsLog($createdItems));
                    $this->em->flush();
                    $this->em->clear();
                }
                $progresses[$id] = $count;
                $sql = 'update command_log set current=' . $count . " where id=" . $this->commandLog->getId();
                $num_rows_effected = $conn->exec($sql);
            }

            $this->em->flush();
            $this->em->clear();
            unset($items);
            unset($mapping);

            //update hometabs
            //$resultCode = $this->makeHomeTabs(false);

            $this->commandLog = $this->em->getRepository('NumaDOAAdminBundle:CommandLog')->find($this->commandLog->getId());
            $this->commandLog->setFullDetails($this->makeDetailsLog($createdItems));
            $this->commandLog->setEndedAt(new \DateTime());
            $this->commandLog->setStatus('finished');
            $this->em->flush();
        } catch (Exception $ex) {
            trigger_error("ERROR", E_USER_ERROR);
        }
    }

    public function makeDetailsLog($createdItems) {
        $output = "";
        $count = 0;
        if (!empty($createdItems)) {
            foreach ($createdItems as $key => $item) {
                $count++;
                $output .= "<strong>" . $key . ":" . $item->getId() . "</strong>";
                $output .= "<br>";
                foreach ($item->getItemFieldsArray() as $key2 => $field) {
                    $output .= "<div>" . $key2 . ":";
                    if (!empty($field['stringvalue'])) {
                        $output .= $field['stringvalue'];
                    }
                    $output .="</div>";
                }
                if ($count > 50) {
                    return $output;
                }
            }
        }
        return $output;
    }

    /**
     * Creates array for tabs on homepage
     */
    function makeHomeTabs($echo = true) {
        if ($echo) {
            print_r("Making home tabs\n");
        }
        $aCategories = array(1, 2, 3, 4, 13);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $categories = $em->getRepository('NumaDOAAdminBundle:Category')->findAll();
        $tabs = array();
        //remove old hometabs
        $oldHometabs = $em->getRepository('NumaDOAAdminBundle:HomeTab')->findAll();
        foreach ($oldHometabs as $hometab) {
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

                        //$items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(), 'field_integer_value' => $value->getId()));
                        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('Category' => $cat, 'type' => $value->getValue()));

                        $count = count($items);

                        if ($echo) {

                            echo $count . ":" . $subCat->getId() . ":" . $value->getId() . ":" . $value->getValue() . "\n";
                        }
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
            } else if ($cat->getId() == 4 || $cat->getId() == 3) {
                //RV
                $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Type', 'category_sid' => $cat->getId()));
                if (!empty($subCat)) {

                    $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));

                    foreach ($list as $key => $value) {

                        //$items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(), 'field_integer_value' => $value->getId()));
                        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('Category' => $cat, 'type' => $value->getValue()));

                        $count = count($items);
                        if ($echo) {
                            print_r(count($items));
                            echo $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n";
                            //dump($echo);
                        }
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
            } else if ($cat->getId() == 1) {
                //find subcategory of category(car and body style)

                $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Body Style', 'category_sid' => $cat->getId()));
                if (!empty($subCat)) {
                    $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                    //list of all subcategoryes
                    foreach ($list as $key => $value) {
                        //count each and put to hometabs
                        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('Category' => $cat, 'body_style' => $value->getValue()));
                        $count = count($items);
                        if ($echo) {
                            print_r(count($items));
                            echo ":" . $subCat->getId() . ":" . $value->getId() . "\n";
                        }
                        $hometab = new HomeTab();
                        $hometab->setCategoryId($cat->getId());
                        $hometab->setCategoryName($cat->getName());
                        $hometab->setListingFieldLists($value);
                        $hometab->setListingFieldListValue($value->getValue());
                        $hometab->setCount($count);
                        $em->persist($hometab);
                    }
                    $em->flush();
                }
            } else if ($cat->getId() == 13) {
                //Ag
                //
                $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Ag Application', 'category_sid' => $cat->getId()));
                if (!empty($subCat)) {

                    $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                    foreach ($list as $key => $value) {
                        //$items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(), 'field_integer_value' => $value->getId()));
                        $items = $em->getRepository('NumaDOAAdminBundle:Item')->getItemBySubCats($cat->getId(), $value->getValue());

                        $count = count($items);
                        if ($echo) {
                            echo count($items) . ":" . $subCat->getId() . ":" . $value->getId() . "::" . $value->getValue() . "\n";
                        }
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

    function equalizeAllItems() {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();
        foreach ($items as $item) {
            if ($item instanceof \Numa\DOAAdminBundle\Entity\Item) {
                $item->equalizeItemFields();
            }
        }
        $em->flush();
    }

}
