<?php

namespace Numa\DOAAdminBundle\Command;

use Numa\DOAAdminBundle\Entity\Catalogcategory;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\DealerCategories;
use Numa\DOAAdminBundle\Lib\RemoteFeed;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Numa\DOAAdminBundle\Entity\HomeTab;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\CommandLog;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

class DBUtilsCommand extends ContainerAwareCommand
{
    protected $command_log;
    protected function configure()
    {
        $this
            ->setName('numa:dbutil')
            ->addArgument('function', InputArgument::OPTIONAL, 'Command name')
            ->addArgument('feed_id', InputArgument::OPTIONAL, 'feed id')
            ->setDescription('fix listing fields table');
    }

    public function makeListingFromTemp()
    {
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('function');
        $feed_id = $input->getArgument('feed_id');
        $dealer_id = $input->getArgument('feed_id');
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
        } elseif ($command == 'dealerize') {
            $this->dealerize();
        } elseif ($command == 'cacheclear') {
            $this->cacheClear();
        } elseif ($command == 'listingListSlug') {
            $this->listingListSlug();
        } elseif ($command == 'test') {
            $this->test();
        } elseif ($command == 'photos') {
            $this->generateCoverPhotos();
        } elseif ($command == 'pages') {
            $this->pages($dealer_id);
        } elseif ($command == 'populate') {
            $this->populate();
        } elseif ($command == 'vindecoder') {
            $item_id = $feed_id;
            $this->vindecoder($item_id);
        } elseif ($command == 'kijiji') {
            $dealer_id = $feed_id;
            $this->kijiji($dealer_id);
        } elseif ($command == 'kijiji_all') {

            $this->kijijiAllDealers();
        }
    }

    public function startCommand($em)
    {
        $logger = $this->getContainer()->get('logger');
        $logger->addWarning("startCommand start");
        $emlog = $this->getContainer()->get('doctrine')->getManager();
        $commands = $em->getRepository('NumaDOAAdminBundle:CommandLog')->findBy(array('status' => 'pending'));
        $logger->addWarning("startCommand start: " . count($commands));
        foreach ($commands as $command) {
            $commandSplit = explode(" ", $command->getCommand());
            $feedId = end($commandSplit);
            $commandDB = $emlog->getRepository('NumaDOAAdminBundle:CommandLog')->find($command->getId());
            $commandDB->setStatus("Executed");
            $emlog->flush();
            $logger->addWarning("startCommand fetch: " . $feedId);
            $this->fetchFeed($feedId, $em);
        }
        $logger->addWarning("startCommand END: " . count($commands));
        //echo "aaaaa";
        //die();
    }

    public function fetchFeed2($feed_id)
    {

        $Controller = new \Numa\DOAAdminBundle\Controller\ImportmappingController();

        $Controller->fetchAction(null, $feed_id);
        //print_r($feed_id);
        //die("aaaaa");
    }

    public function myErrorHandler($errno, $errstr, $errfile, $errline)
    {

        $errorFullDetail = "Error: [$errno] $errstr<br />$errfile : $errline\n";
        //dump($errorFullDetail);
        $this->commandLog->setStatus("ERROR");
        $this->commandLog->setFullDetails($errorFullDetail);
        $this->em->flush();
        $this->em->clear();
        dump($errorFullDetail);
        exit(1);
    }

    public function fetchFeed($id, $em)
    {
        try {
            $logger = $this->getContainer()->get('logger');
            $this->em = $em;
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
            $conn = $em->getConnection();

            $this->commandLog = new CommandLog();
            $this->commandLog->setCategory('fetch');
            $this->commandLog->setStartedAt(new \DateTime());
            $this->commandLog->setStatus('started');

            $this->commandLog->setCommand($this->getName() . " fetchFeed " . $id);
            $this->em->persist($this->commandLog);
            $this->em->flush();
            $logger->warning("FETCH FEED: Flush init command log");
            $memcache = $this->getContainer()->get('mymemcache');
            $createdItems = array();
            $feed_id = $id;
            $remoteFeed = new RemoteFeed($id);
            $items = $remoteFeed->getRemoteItems();
            $logger->warning("FETCH FEED: getRemote items");

            $sql = 'update command_log set count=' . count($items) . " where id=" . $this->commandLog->getId();
            $num_rows_effected = $conn->exec($sql);

            //print items
            //


            unset($remoteFeed);

            $mapping = $this->em->getRepository('NumaDOAAdminBundle:Importmapping')->findBy(array('feed_sid' => $feed_id));
            $this->em->getConnection()->beginTransaction();
            $sold = $this->em->getRepository('NumaDOAAdminBundle:Item')->setSoldOnAllItemInFeed($feed_id);
            $this->em->flush();

            $upload_url = $this->getContainer()->getParameter('upload_url');
            $upload_path = $this->getContainer()->getParameter('upload_path');

            //echo "Memory usage in fetchAction inside1: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
            $count = 0;
            $logger->warning("FETCH FEED: before items loop");

            foreach ($items as $importItem) {

                $item = $this->em->getRepository('NumaDOAAdminBundle:Item')->importRemoteItem($importItem, $mapping, $feed_id, $upload_url, $upload_path, $em);

                if (!empty($item)) {
                    $createdItems[] = $item;
                }

                unset($item);
                //echo "Memory usage in fetchAction inloop: " . $count . "::" . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
                $count++;
                if ($count % 200 == 0) {
                    $this->commandLog->setFullDetails($this->makeDetailsLog($createdItems));
                }

                $progresses[$id] = $count;
                $sql = 'update command_log set current=' . $count . " where id=" . $this->commandLog->getId();

                $memcache->set("command:progress:" . $this->commandLog->getId(), $count);
                if ($count % 50 == 0) {
                    $logger->warning("FETCH FEED: flush 50");
                    $this->em->flush();
                    //$this->em->getConnection()->commit();
                    $this->em->clear();
                }
            }

            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->em->clear();
            $logger->warning("FETCH FEED: flush LAST");
            unset($items);
            unset($mapping);

            //update hometabs
            $logger->warning("FETCH FEED: before hometabs");
            $this->makeHomeTabs(false);
            $logger->warning("FETCH FEED: after hometabs");
            $this->commandLog = $this->em->getRepository('NumaDOAAdminBundle:CommandLog')->find($this->commandLog->getId());

            $this->commandLog->setFullDetails($this->makeDetailsLog($createdItems));
            $this->commandLog->setEndedAt(new \DateTime());
            $this->commandLog->setStatus('finished');
            $this->commandLog->setCurrent($count);
            $logger->warning("FETCH FEED: before SEO");
            //
            $seoService = $this->getContainer()->get("Numa.Seo");
            $seo = $seoService->generateSeoForFeed($feed_id);
            $logger->warning("FETCH FEED: END");

            $this->generateCoverPhotos();
            $this->populate();

            die();

        } catch (Exception $ex) {

            trigger_error("ERROR", E_USER_ERROR);
        }
    }

    public function makeDetailsLog($createdItems)
    {
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
                    $output .= "</div>";
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
    function makeHomeTabs($echo = true)
    {
        $logger = $this->getContainer()->get('logger');
        if ($echo) {
            print_r("Making home tabs\n");
        }
        $logger->warning("HOMETABS: Start echo:" . $echo);
        //$aCategories = array(1, 2, 3, 4, 13);
        //$this->getContainer()->get('doctrine')->resetEntityManager();
        $em = $this->getContainer()->get('doctrine')->getManager();

        //only active listings
        $filters = $em->getFilters()
            ->enable('active_filter');
        $filters->setParameter('active', true);
        $logger->warning("HOMETABS: set active filters");

        $categories = $em->getRepository('NumaDOAAdminBundle:Category')->findAll();
        $logger->warning("HOMETABS: find all categories");
        //remove old hometabs
        $em->getRepository('NumaDOAAdminBundle:HomeTab')->deleteAllHomeTabs();
        $logger->warning("HOMETABS: delete old hometabs");
        //dump($dealers);die();
        //make all tabs for all listings
        $memcache = $this->getContainer()->get('mymemcache');
        foreach ($categories as $cat) {
            $logger->warning("HOMETABS: make hometabs for category=" . $cat->getId());
            $this->makeHomeTabForCategory($cat, null, $echo);
        }
        $logger->warning("HOMETABS: makeHomeTabForCategory end");
        $memcache->delete('hometabs_');
        //make tabs for defined dealers
        $settings = $em->getRepository('NumaDOASettingsBundle:Setting')->findDealers();
        $logger->warning("HOMETABS: collect the dealers");
        foreach ($settings as $dealer) {

            foreach ($categories as $cat) {
                if ($dealer->getDealer() instanceof Catalogrecords) {
                    $logger->warning("HOMETABS:make home tabs for category" . $cat);
                    $this->makeHomeTabForCategory($cat, $dealer->getDealer(), $echo);

                    $memcache->delete('hometabs_' . $dealer->getDealer());
                    $logger->warning("HOMETABS: Delete memcache");
                }
            }
        }
    }

    public function makeHomeTabForCategory($cat, $dealer = null, $echo = true)
    {
        $list = "";
        $logger = $this->getContainer()->get('logger');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $logger->addWarning("makeHomeTabForCategory " . $cat);
        if ($cat->getId() == 2) {
            //Marine
            $logger->addWarning("makeHomeTabForCategory 22222");
            $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneByCaption('Boat Type');
            if (!empty($subCat)) {
                $logger->addWarning("makeHomeTabForCategory inside subcat boat type");
                $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                $logger->addWarning("makeHomeTabForCategory before values loop cat=2");
                foreach ($list as $key => $value) {

                    $items = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), $value->getValue(), $dealer);
                    $logger->addWarning("makeHomeTabForCategory inside values loop items fetched, count items:" . count($items));
                    $count = count($items);

                    if ($echo) {
                        echo $count . ":" . $subCat->getId() . ":" . $value->getId() . ":" . $value->getValue() . "\n";
                    }
                    $logger->addWarning("makeHomeTabForCategory:" . $count . ":" . $subCat->getId() . ":" . $value->getId() . ":" . $value->getValue() . "\n");
                    //$count = $items->count();
                    $hometab = new HomeTab();


                    $hometab->setCategoryId($cat->getId());
                    $hometab->setCategoryName($cat->getName());
                    $hometab->setListingFieldLists($value);
                    $hometab->setListingFieldListValue($value->getValue());
                    $hometab->setListingFieldListSlug($value->getSlug());
                    $hometab->setCount($count);
                    $logger->addWarning("makeHomeTabForCategory hometabs creating for CAT=2");
                    if ($dealer instanceof Catalogrecords) {
                        $logger->addWarning("makeHomeTabForCategory hometabs dealers for CAT=2");
                        $hometab->setDealer($em->getReference('Numa\DOAAdminBundle\Entity\Catalogrecords', $dealer->getId()));
                    }
                    $logger->addWarning("makeHomeTabForCategory hometabs persists for CAT=2");
                    $em->persist($hometab);
                    //print_r($key);
                }

                //die();
                //$em->flush();
            }
        } else if ($cat->getId() == 4 || $cat->getId() == 3) {
            //RV
            $logger->addWarning("makeHomeTabForCategory STARTS CAT=4 and 3");
            $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Type', 'category_sid' => $cat->getId()));
            if (!empty($subCat)) {
                $logger->addWarning("makeHomeTabForCategory inside subcat type CAT=4 and 3");
                $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));

                foreach ($list as $key => $value) {

                    $logger->addWarning("makeHomeTabForCategory inside values loop CAT=4 and 3");
                    $items = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), $value->getValue(), $dealer);
                    $count = count($items);

                    if ($echo) {
                        echo $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n";
                    }

                    if ($value->getValue() == "Class B and C Motorhome") {

                        $items1 = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), "Class B Motorhome", $dealer);
                        $items2 = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), "Class C Motorhome", $dealer);
                        $count = count($items1);
                        $count = $count + count($items2);

                    }
                    $logger->addWarning("makeHomeTabForCategory CAT=4 and 3::" . $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n");
                    //$count = $items->count();
                    $hometab = new HomeTab();
                    if ($dealer instanceof Catalogrecords) {
                        $logger->addWarning("makeHomeTabForCategory hometabs dealers CAT=4 and 3::");
                        $hometab->setDealer($em->getReference('Numa\DOAAdminBundle\Entity\Catalogrecords', $dealer->getId()));
                    }
                    $hometab->setCategoryId($cat->getId());
                    $hometab->setCategoryName($cat->getName());
                    $hometab->setListingFieldLists($value);
                    $hometab->setListingFieldListValue($value->getValue());
                    $hometab->setListingFieldListSlug($value->getSlug());
                    $hometab->setCount($count);
                    $em->persist($hometab);
                    $logger->addWarning("makeHomeTabForCategory hometabs persists CAT=4 and 3::");
                    //print_r($key);
                }
                //$em->flush();
            }
        } else if ($cat->getId() == 1) {
            //find subcategory of category(car and body style)
            $logger->warning("makeHomeTabForCategory 1");
            $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Body Style', 'category_sid' => $cat->getId()));
            $logger->warning("makeHomeTabForCategory 1 subcats" . $subCat->getId());
            if (!empty($subCat)) {
                $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                $logger->warning("makeHomeTabForCategory 1 list");
                //list of all subcategoryes
                foreach ($list as $key => $value) {
                    $logger->warning("makeHomeTabForCategory 1 foreach inside: " . $value);
                    //count each and put to hometabs
                    //$items = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('Category' => $cat, 'body_style' => $value->getValue()));
                    $items = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), $value->getValue(), $dealer);

                    $count = count($items);
                    $logger->warning("makeHomeTabForCategory 1 foreach inside: " . $count . " " . $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n");
                    if ($echo) {
                        $logger->warning("makeHomeTabForCategory 1 foreach inside echo: " . $echo);
                        echo $count . " " . $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n";
                    }
                    $logger->warning("makeHomeTabForCategory 1" . $count . " " . $subCat->getCaption() . " : " . $subCat->getId() . ":" . $value->getId() . " : " . $value->getValue() . "\n");
                    $hometab = new HomeTab();
                    $logger->warning("makeHomeTabForCategory 1 hometabs entity");

                    if ($dealer instanceof Catalogrecords) {
                        $logger->warning("makeHomeTabForCategory set dealer=" . $dealer->getId());
                        $hometab->setDealer($em->getReference('Numa\DOAAdminBundle\Entity\Catalogrecords', $dealer->getId()));
                        $logger->warning("makeHomeTabForCategory set dealer=" . $dealer->getId());
                    }
                    $logger->warning("makeHomeTabForCategory 1 hometab entity set");
                    $hometab->setCategoryId($cat->getId());
                    $hometab->setCategoryName($cat->getName());
                    $hometab->setListingFieldLists($value);
                    $hometab->setListingFieldListValue($value->getValue());
                    $hometab->setListingFieldListSlug($value->getSlug());
                    $hometab->setCount($count);
                    $em->persist($hometab);
                    $logger->warning("makeHomeTabForCategory 1 persists");
                }
                //$em->flush();
            }
        } else if ($cat->getId() == 13) {
            //Ag
            //
            $logger->warning("makeHomeTabForCategory CAT=13");
            $subCat = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Ag Application', 'category_sid' => $cat->getId()));
            if (!empty($subCat)) {
                $logger->warning("makeHomeTabForCategory inside subcat ag application CAT=13");
                $list = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findBy(array('listing_field_id' => $subCat->getId()));
                foreach ($list as $key => $value) {
                    $logger->warning("makeHomeTabForCategory inside values loop CAT=13");
                    //$items = $em->getRepository('NumaDOAAdminBundle:ItemField')->findBy(array('field_id' => $subCat->getId(), 'field_integer_value' => $value->getId()));
                    //$items = $em->getRepository('NumaDOAAdminBundle:Item')->getItemBySubCats($cat->getId(), $value->getValue());
                    $items = $em->getRepository('NumaDOAAdminBundle:Item')->getByCategoryTypeDealer($cat->getId(), $value->getValue(), $dealer);
                    $count = count($items);
                    if ($echo) {
                        echo count($items) . ":" . $subCat->getId() . ":" . $value->getId() . "::" . $value->getValue() . "\n";
                    }
                    $logger->warning("makeHomeTabForCategory inside values loop CAT=13::::" . count($items) . ":" . $subCat->getId() . ":" . $value->getId() . "::" . $value->getValue() . "\n");
                    //$count = $items->count();
                    $hometab = new HomeTab();
                    if ($dealer instanceof Catalogrecords) {
                        $logger->warning("makeHomeTabForCategory hometab dealer CAT=13::::");
                        $hometab->setDealer($em->getReference('Numa\DOAAdminBundle\Entity\Catalogrecords', $dealer->getId()));
                    }
                    $hometab->setCategoryId($cat->getId());
                    $hometab->setCategoryName($cat->getName());
                    $hometab->setListingFieldLists($value);
                    $hometab->setListingFieldListValue($value->getValue());
                    $hometab->setListingFieldListSlug($value->getSlug());
                    $hometab->setCount($count);
                    $logger->warning("makeHomeTabForCategory hometab persists CAT=13::::");
                    $em->persist($hometab);
                    //print_r($key);
                }

            }
        }

        $em->flush();
        $logger->warning("makeHomeTabForCategory 1 flush");
        $em->clear();


        //dump($memcache->get('hometabs'));
    }

    function equalizeAllItems()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $items = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();
        foreach ($items as $item) {
            if ($item instanceof \Numa\DOAAdminBundle\Entity\Item) {
                $item->equalizeItemFields();
            }
        }
        $em->flush();
    }

    public function dealerize()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dealers = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findAll();
        foreach ($dealers as $dealer) {
            if ($dealer instanceof Catalogrecords) {
                $onetoonecat = $dealer->getCatalogcategory();
                if ($onetoonecat instanceof Catalogcategory) {
                    $dc = new DealerCategories();
                    $dcategory = $em->getRepository('NumaDOAAdminBundle:Dcategory')->find($onetoonecat->getId());
                    $dc->setDcategory($dcategory);
                    $dc->setCatalogrecords($dealer);
                    $em->persist($dc);
                }

            }
        }
        $em->flush();

    }

    public function cacheClear()
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $listings = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAll();

        $lastCache = $em->getRepository("NumaDOAAdminBundle:CommandLog")->findOneBy(array('category' => "cacheclear"), array('id' => 'desc'));

        if ($lastCache instanceof CommandLog) {
            if ($lastCache->isRunning()) {
                die();
            }
        }

        $commandLog = new CommandLog();
        $commandLog->setCategory('cacheclear');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');
        $commandLog->setCommand('cacheclear');
        $em->persist($commandLog);
        $em->flush();
        $logger = $this->getContainer()->get('logger');

        $logger->warning("CLEAR CACHE set permission back");
        $command = 'chmod -R 777 ' . $this->getContainer()->get('kernel')->getRootDir() . '/cache ' . $this->getContainer()->get('kernel')->getRootDir() . '/logs';
        $process = new \Symfony\Component\Process\Process($command);
        $process->run();

        $logger->warning("CLEAR HTTP CACHE");
        $command = 'php ' . $this->getContainer()->get('kernel')->getRootDir() . '/console cache:clear -e prod';
        $process = new \Symfony\Component\Process\Process($command);
        $process->run();
        $logger->warning("CLEAR MEMCACHED CACHE");
        $command = '/etc/init.d/memcached restart';
        $process = new \Symfony\Component\Process\Process($command);
        $process->run();
        $logger->warning("CLEAR CACHE set permission back");
        $command = 'chmod -R 777 ' . $this->getContainer()->get('kernel')->getRootDir() . '/cache ' . $this->getContainer()->get('kernel')->getRootDir() . '/logs';
        $process = new \Symfony\Component\Process\Process($command);
        $process->run();
        $commandLog->setEndedAt(new \DateTime());
        $commandLog->setStatus('finished');
        $em->flush();

    }

    public function listingListSlug()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $listings = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findAll();

        foreach ($listings as $listing) {

            if ($listing instanceof \Numa\DOAAdminBundle\Entity\ListingFieldLists) {

                $slug = strtolower($listing->getValue());
                $slug = str_replace(" ", "-", $slug);
                $slug = str_replace("/", "-", $slug);
                $slug = str_replace("---", "-", $slug);
                $slug = str_replace("--", "-", $slug);

                $listing->setSlug($slug);
                dump($slug);
            }
        }
        $em->flush();
    }

    public function generateCoverPhotos()
    {
        $logger = $this->getContainer()->get('logger');
        $logger->warning("COVER PHOTOS STARTED");
        $commandLog = new CommandLog();
        $commandLog->setCategory('photos');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');

        $commandLog->setCommand($this->getName() . " photos ");
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getRepository("NumaDOAAdminBundle:Item")->generateCoverPhotos();

        $logger->warning("COVER PHOTOS STARTED loop end");
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
        $logger->warning("COVER PHOTOS FINISHED");
        //die();
    }


    public function rvsubcats()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $logger = $this->getContainer()->get('logger');
        $logger->warning("RVSUBCATS STARTED");
        $commandLog = new CommandLog();
        $commandLog->setCategory('rvsubcats');
        $commandLog->setStartedAt(new \DateTime());
        $commandLog->setStatus('started');

        $commandLog->setCommand($this->getName() . " rvsubcats ");
        $listings = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();
        $commandLog->setCount(count($listings));
        $logger->warning("RVSUBCATS STARTED persists");
        $em->persist($commandLog);
        $em->flush();
        $listings = $em->getRepository('NumaDOAAdminBundle:Item')->findAll();
        $i = 0;
        $logger->warning("RVSUBCATS STARTED loop");
        //UPDATE `item` SET TYPE = "Class B and C Motorhome" WHERE TYPE LIKE '%C Motorhome%' OR TYPE LIKE '%B Motorhome%'
        //INSERT INTO `listing_field_list` (`id`, `listing_field_id`, `order`, `value`, `slug`) VALUES
        //(366, 746, 4, 'Class B Motorhome', 'class-b-motorhome');
        //INSERT INTO `listing_field_list` (`id`, `listing_field_id`, `order`, `value`, `slug`) VALUES (NULL, '746', '8', 'Park Model', 'park-model');
        //UPDATE `listing_field_list` SET `value` = 'Planting and Seeding', `slug` = 'planting-seeding' WHERE slug like '%planting%'
        $logger->warning("COVER PHOTOS STARTED loop end");
        $commandLog->setStatus('finished');
        $em->flush();
        $em->clear();
        $logger->warning("COVER PHOTOS FINISHED");
    }


    public function test()
    {
        $seoService = $this->getContainer()->get("Numa.Seo");
        $seo = $seoService->generateSeoForFeed(1);

        die();
    }

    public function pages($dealer_id)
    {

        $pages = $this->getContainer()->get("Numa.DMSUtils")->generatePagesForDealer($dealer_id);
        die();
    }

    public function populate()
    {
        $em = $this->getContainer()->get('numa.dms.utils')->populateElasticSearch();
    }

    public function vindecoder($item_id)
    {
        $decodedVin = $this->getContainer()->get("numa.dms.listing")->vindecoder($item_id);
        dump($decodedVin);
    }
    public function kijiji($dealer_id)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->find($dealer_id);
        if($dealer instanceof Catalogrecords) {
            $this->kijijiProcessDealer($dealer);
        }
    }
    public function kijijiProcessDealer(Catalogrecords $dealer)
    {
        $dealer_id=$dealer->getId();
        $logger = $this->getContainer()->get('logger');
        $commandLog = $this->getContainer()->get('numa.dms.command.log');
        $command = 'php app/console numa:dbutil kijiji ' . $dealer_id;

        // set up basic connection

        $ftp_server = $dealer->getFeedKijijiUrl();
        $ftp_user_name = $dealer->getFeedKijijiUsername();
        $ftp_user_pass = $dealer->getFeedKijijiPassword();
        if(!empty($ftp_server)) {
            $clo = $commandLog->startNewCommand($command, "feeds");
            $feedsKijiji = $this->getContainer()->get('listing_api')->makeKijijiFromDealerId($dealer_id);

            $commandLog->endCommand($clo);
        }
    }

    public function kijijiAllDealers()
    {
        $logger = $this->getContainer()->get('logger');

        $em = $this->getContainer()->get('doctrine')->getManager();

        $commandLog = $this->getContainer()->get('numa.dms.command.log');
        $command = 'php app/console numa:dbutil kijiji_all';
        $clo = $commandLog->startNewCommand($command, "feeds");

        $dealers = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->findForKijiji();

        foreach ($dealers as $dealer) {
            $logger->warning("Creating feed for dealer: " . $dealer->getUsername());
            $commandLog->append($clo,"Creating feed for dealer: " . $dealer->getUsername());
            $this->kijijiProcessDealer($dealer);
        }

        $commandLog->endCommand($clo);
    }

}
