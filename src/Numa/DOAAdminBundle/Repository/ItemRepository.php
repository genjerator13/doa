<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;

class ItemRepository extends EntityRepository {

    protected $itemFieldsDeleted = false;
    private $memcache;

    public function setMemcached($memcachce) {
        $this->memcache = $memcachce;
    }

    public function getItemFields($item_id) {

        $q = 'SELECT i FROM ItemField WHERE i.item_id=' . $item_id;
        $query = $this->getEntityManager()
                ->createQuery($q);
        $res = $query->getResult();
        return $res;
    }

    public function findFeatured($max = 5) {
        if (empty($max)) {
            $max = 5;
        }
        $em = $this->getEntityManager();
        $res2 = $this->memcache->get('featured');
        
        if (!$res2) {
            
            $q = 'SELECT i  FROM NumaDOAAdminBundle:item i WHERE i.featured=1 AND i.active=1';
            $query = $this->getEntityManager()
                    ->createQuery($q);
            $query->useResultCache(true, 3600, 'featuredSelect');
            $res2 = $query->getArrayResult();
            $this->memcache->get('featured',$res2);
            
        }
        
        $count = count($res2);
        $maxOffset = $count - $max <= 0 ? $count : $max;

        if (!empty($res2)) {

            //$randResult = $this->memcache->get('randomFeaturedads');
            //if ($randResult===false) {
            $rand_keys = array_rand($res2, $maxOffset);
            $randResult = array();
            foreach ($rand_keys as $key) {
                $randResult[] = $res2[$key]['id'];
            }
            //$this->memcache->set('randomFeaturedads',$randResult,false,3600);
            // } 


            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('i')
                    ->from('NumaDOAAdminBundle:Item', 'i')
                    //->join('i.ItemField', 'if')
                    ->andWhere('i.id IN (:ids)')
                    ->setParameter('ids', $randResult)
                    ->setMaxResults(10);
            ;

            $query = $qb->getQuery();
            $query->useResultCache(true, 3600, 'featuredRandomSet');

            $res = $query->getResult(); //->getResult();

            return $res;
            
        }
        return null;
    }

    /**
     * Returns saved ads for the requested user id
     * @param integer $user_id
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function findSavedAds($user_id) {
        $user_id = intval($user_id);

        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('i')->distinct()
                ->add('from', 'NumaDOAAdminBundle:Item i LEFT JOIN i.UserItem ui')
                //->from('NumaDOAAdminBundle:Item', 'i')
                //->join('NumaDOAAdminBundle:UserItem', 'ui')
                ->where('ui.user_id=:user_id')
                ->andWhere('ui.item_type= :item_type')
                ->setParameter('item_type', \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD)
                ->setParameter('user_id', $user_id)
        ;

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery;
    }

    public function getItemFieldSubCats($cat) {
        $subcatname = 'boat subtype'; //test
        if ($cat == 2) {
            $subcatname = 'boat subtype';
        }
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('if.field_string_value')->distinct()
                ->from('NumaDOAAdminBundle:Item', 'i')
                ->join('NumaDOAAdminBundle:ItemField', 'if')
                ->where('if.field_name=:subcatname')
                ->setParameter('subcatname', $subcatname)
        ;

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function getItemBySubCats($cat, $subcatname) {

        $subcat = 'type'; //test
        $cat = intval($cat);
        if ($cat == 13) {
            $subcat = 'ag_application';
        }

        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('i')->distinct()
                ->from('NumaDOAAdminBundle:Item', 'i')
                ->where('i.category_id=:category')
                ->andWhere('i.' . $subcat . ' like :subcatname')
                ->setParameter('subcatname', "%" . $subcatname . "%")
                ->setParameter('category', $cat)
        ;

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //dump($itemsQuery->getSQL());
        return $itemsQuery->getResult();
    }

    public function getItemByCat($category) {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('i')->distinct()
                ->from('NumaDOAAdminBundle:Item', 'i')
        ;

        if(!empty($category)) {
            if(is_numeric($category)) {

                $qb->andWhere("i.category_id like :name");
                $qb->setParameter("name",$category);
            }elseif(is_string($category)){
                $qb->innerJoin("NumaDOAAdminBundle:Category", "c",'WITH','i.category_id=c.id');
                $qb->andWhere("c.name like :name");
                $qb->setParameter("name", "%" . $category . "%");
            }else{
                //return false;
            }
        }

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function getItemByDealerAndCategory($dealer_id,$category=null) {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->where('i.dealer_id=:dealer')
            ->setParameter('dealer', $dealer_id)
        ;
        //dump(is_numeric($category));die();
        if(!empty($category)) {
            if(is_numeric($category)) {

                $qb->andWhere("i.category_id like :name");
                $qb->setParameter("name",$category);
            }elseif(is_string($category)){
                $qb->innerJoin("NumaDOAAdminBundle:Category", "c",'WITH','i.category_id=c.id');
                $qb->andWhere("c.name like :name");
                $qb->setParameter("name", "%" . $category . "%");
            }else{
                return false;
            }
        }

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function removeAllItemFields($item_id) {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = ' . $item_id);
            $numDeleted = $q->execute();
        }
    }

    public function removeAllIImageItemFields($item_id) {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = ' . $item_id. " AND  if.field_name like 'Image List'");
            $numDeleted = $q->execute();
        }
    }

    public function removeAllItemFieldsByFeed($feed_id) {
        $feed_id = intval($feed_id);
        if (!empty($feed_id)) {
            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if  where if.feed_id = ' . $feed_id);
            $numDeleted = $q->execute();
        }
    }

    public function setSoldOnAllItemInFeed($feed_id) {
        $feed_id = intval($feed_id);
        if (!empty($feed_id)) {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->update('NumaDOAAdminBundle:Item', 'i')
                    ->andWhere('i.feed_id = :ids')
                    ->setParameter('ids', $feed_id)
                    ->set('i.sold', 1);
            $q = $qb->getQuery();
            $q->execute();
        }
    }

    public function findItemByUniqueField($uniqueField, $value) {


        if (is_array($value)) {
            return false;
        }
        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i JOIN i.ItemField if WHERE if.field_name=\'' . $uniqueField . '\' and if.field_string_value =\'' . $value . '\'';
        $itemsQuery = $this->getEntityManager()
                        ->createQuery($q)->setMaxResults(1);

        //$itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //print_r($value);echo "::::";
        //print_r($uniqueField);echo "\n";
        //
        return $itemsQuery->getOneOrNullResult();
    }

    public function removeItemsByFeed($feed_id) {
        $feed_id = intval($feed_id);
        $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:Item i where i.feed_id = ' . $feed_id);
        $numDeleted = $q->execute();
    }

    /**
     * Imports single remote listing(Item)
     * @param type $importItem (array remote Item)
     * @param type $mapping (mapping row)
     * @param type $feed_id (id of the feed
     * @param type $upload_url 
     * @param type $upload_path
     * @param type $em
     * @return \Numa\DOAAdminBundle\Entity\Item|null
     */
    public function importRemoteItem($importItem, $mapping, $feed_id, $upload_url, $upload_path, $em) {
        //echo "Memory usage in importRemoteItem before: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";

        $feed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($feed_id);
        $uniqueField = $feed->getUniqueField();
        $processed = false;
        $persist = false;

        $uniqueMapRow = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findMapRow($feed->getId(), $uniqueField);
        $uniqueValue = "";
        if (!empty($importItem[$uniqueField])) {
            $uniqueValue = $importItem[$uniqueField];
        }
        if (!empty($uniqueField)) {

            if (!empty($uniqueMapRow) && $uniqueMapRow->getListingField() instanceof \Numa\DOAAdminBundle\Entity\Listingfield) {
                $item = $this->findItemByUniqueField($uniqueMapRow->getListingField()->getCaption(), $uniqueValue);
            }
        }
        unset($uniqueMapRow);
        unset($uniqueField);

        if (empty($item)) {
            if ($feed->getPhotoFeed()) {

                return null;
            }
            $persist = true;
            $item = new Item();
        }
        if (!empty($feed_id)) {

            $item->setImportfeed($feed);
        }
        $item->setSold(0);
        //clear all item fields if not photo feed

        if (!$feed->getPhotoFeed()) {
            $this->removeAllItemFields($item->getId());
        } else {
            if (!$this->itemFieldsDeleted) {
                $this->removeAllIImageItemFields($feed->getId());
                $this->itemFieldsDeleted = true;
            }
        }

        foreach ($mapping as $maprow) {

            $property = $maprow->getSid();

            $processed = false;
            $listingFields = $maprow->getListingField();
            //check if there are predefined listing field in database (listing_field_lists)
            if (!empty($listingFields) && !empty($importItem[$property])) {
                $stringValue = $importItem[$property];
                $listingFieldsType = $listingFields->getType();

                $itemField = new ItemField();
                $itemField->setAllValues($stringValue, $maprow->getValueMapValues());
                $itemField->setFeedId($feed->getId());
                if ($listingFields instanceof Listingfield) {
                    $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->find($maprow->getListingField()->getId());
                    if ($test instanceof Listingfield) {

                        $itemField->setListingfield($test);
                    }
                    //$itemField->setListingfield($listingFields); //will set caption and type by listing field
                    //$itemField->setFieldName($listingFields->getCaption());
                    //$itemField->setFieldType($listingFields->getType());
                }
                $stringValue = trim($itemField->getFieldStringValue());

                //if xml property has children then do each child
                if (!empty($listingFieldsType) && $listingFieldsType == 'list') {
                    $listValues = $listingFields->getListingFieldLists();

                    if (count($listValues) > 0) {

                        //get listingFieldlist by ID and stringValue
                        $listingList = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findOneByValue($stringValue, $maprow->getListingField()->getId());
                        if ($listingList instanceof \Numa\DOAAdminBundle\Entity\ListingFieldLists) {
                            $itemField->setFieldIntegerValue($listingList->getId());
                        }
                    }
                }

                //if xml property has children then do each child
                if (!empty($listingFieldsType) && $listingFieldsType == 'tree') {
                    //get listingFieldlist by ID and stringValue
                    $listingTree = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->findOneByValue($stringValue, $maprow->getListingField()->getId());
                    //echo $stringValue.", ".$maprow->getListingFields()->getId();die(); {
                    if ($listingTree instanceof ListingFieldTree) {
                        $itemField->setFieldIntegerValue($listingTree->getId());
                    }
                }

                if (!empty($listingFieldsType) && $listingFieldsType == 'array') {
                    //check if string or array

                    $json = json_decode($stringValue, true);

                    if (!empty($json) && is_array($json)) {
                        if (!empty($json['image']) && is_array($json['image'])) {
                            $temp = array();
                            foreach ($json['image'] as $key => $value) {
                                if (!empty($value['filePointer'])) {
                                    $temp[] = $value['filePointer'];
                                }
                            }
                            $item->proccessImagesFromRemote($temp, $maprow, $feed, $upload_path, $upload_url, $em, $uniqueValue);
                        } else {
                            $item->proccessImagesFromRemote($json, $maprow, $feed, $upload_path, $upload_url, $em, $uniqueValue);
                        }
                    } else {
                        ///TODO
                        $item->proccessImagesFromRemote($stringValue, $maprow, $feed, $upload_path, $upload_url, $em, $uniqueValue);
                    }
                    $processed = true;
                } else {
                    
                }

                if (!empty($listingFieldsType) && $listingFieldsType == 'options') {
                    $processed = true;
                    $item->processOptionsList($stringValue, $feed->getOptionsSeparator());
                }

                if (!$processed) {
                    if ($itemField instanceof \Numa\DOAAdminBundle\Entity\ItemField) {
                        $item->addItemField($itemField);
                    }
                }
                //connect with dealer

                if (stripos($listingFields->getSid(), 'dealer') !== false) {

                    $dealerId = $stringValue;

                    $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('dealer_id' => $dealerId));

                    if ($dealer instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {
                        $item->setDealer($dealer);
                    }
                    unset($dealer);
                    unset($dealerId);
                }
            }
            unset($itemField);
            unset($stringValue);
            unset($listingFieldsType);
            unset($property);
        }//end mapping foreach

        $item->equalizeItemFields();
        if ($persist) {
            $em->persist($item);
        }

        //echo "Memory usage  in importRemoteItem after: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";
        return $item;
    }

}
