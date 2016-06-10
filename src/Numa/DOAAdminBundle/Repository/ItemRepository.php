<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;

class ItemRepository extends EntityRepository
{

    protected $itemFieldsDeleted = false;
    private $memcache;

    public function setMemcached($memcachce)
    {
        $this->memcache = $memcachce;
    }

    public function getItemFields($item_id)
    {

        $q = 'SELECT i FROM ItemField WHERE i.item_id=' . $item_id;
        $query = $this->getEntityManager()
            ->createQuery($q);
        $res = $query->getResult();
        return $res;
    }

    public function findFeatured($dealer_id="",$max = 5)
    {
        if (empty($max)) {
            $max = 5;
        }
        $dealer_id = empty($dealer_id)?"":$dealer_id;

        $res2 = $this->memcache->get('featured_'.$dealer_id);

        if (!$res2) {

            $q = 'SELECT i  FROM NumaDOAAdminBundle:item i WHERE i.featured=1 AND i.active=1';
            if(!empty($dealer_id)){
                $q = $q." AND i.dealer_id=".intval($dealer_id);
            }

            $query = $this->getEntityManager()
                ->createQuery($q);
            // $query->useResultCache(true, 3600, 'featuredSelect_'.$dealer_id);
            //dump($query);die();
            $res2 = $query->getArrayResult();
            $this->memcache->set('featured_'.$dealer_id, $res2);

        }

        $count = count($res2);
        $maxOffset = $count - $max <= 0 ? $count : $max;
        if (!empty($res2)) {

            $rand_keys = array_rand($res2, $maxOffset);
            $randResult = array();
            foreach ($rand_keys as $key) {
                $randResult[] = $res2[$key]['id'];
            }

            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('i')
                    ->from('NumaDOAAdminBundle:Item', 'i')
                    ->andWhere('i.id IN (:ids)')
                    ->setParameter('ids', $randResult)
                    ->setMaxResults(10);
            ;
            if(!empty($dealer_id)){
                $qb->andWhere('i.dealer_id=:dealer_id');
                $qb->setParameter('dealer_id',intval($dealer_id));
            }

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
    public function findSavedAds($user_id)
    {
        $user_id = intval($user_id);

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Item i LEFT JOIN i.UserItem ui')
            ->where('ui.user_id=:user_id')
            ->andWhere('ui.item_type= :item_type')
            ->setParameter('item_type', \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD)
            ->setParameter('user_id', $user_id);

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery;
    }

    public function getItemFieldSubCats($cat)
    {
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
            ->setParameter('subcatname', $subcatname);

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function getItemBySubCats($cat, $subcatname)
    {

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
            ->setParameter('category', $cat);

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function getItemByCat($category)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i');

        if (!empty($category)) {
            if (is_numeric($category)) {

                $qb->andWhere("i.category_id like :name");
                $qb->setParameter("name", $category);
            } elseif (is_string($category)) {
                $qb->innerJoin("NumaDOAAdminBundle:Category", "c", 'WITH', 'i.category_id=c.id');
                $qb->andWhere("c.name like :name");
                $qb->setParameter("name", "%" . $category . "%");
            } else {
                //return false;
            }
        }

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        return $itemsQuery->getResult();
    }

    public function getItemByDealerAndCategory($dealer_id, $category = null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i');
        if(empty($dealer_id)){

        }elseif (is_numeric($dealer_id)) {
            $qb->where('i.dealer_id=:dealer');
            $qb->setParameter('dealer', $dealer_id);
        } elseif (is_string($dealer_id)) {
            $qb->Join("NumaDOAAdminBundle:Catalogrecords", "d", 'WITH', 'i.dealer_id=d.id');
            $qb->andWhere("d.username like :dealer");
            $qb->setParameter("dealer", "%" . $dealer_id . "%");
        };

        if (!empty($category)) {
            if (is_numeric($category)) {

                $qb->andWhere("i.category_id like :name");
                $qb->setParameter("name", $category);
            } elseif (is_string($category)) {
                $qb->innerJoin("NumaDOAAdminBundle:Category", "c", 'WITH', 'i.category_id=c.id');
                $qb->andWhere("c.name like :name");
                $qb->setParameter("name", "%" . $category . "%");
            } else {
                return false;
            }
        }
        $qb->andWhere("i.active=1");
        //$qb->setParameter("dealer", "%" . $dealer_id . "%");
        $itemsQuery = $qb->getQuery()->useResultCache(true); //getOneOrNullResult();

        return $itemsQuery->getResult();
    }


    public function getAllListings(){
        //$sql = "SELECT * FROM item";
        $sql = "SELECT DISTINCT f.sort_order, i. * , f.field_string_value as photo
FROM item AS i
RIGHT JOIN item_field AS f ON i.id = f.item_id
WHERE i.active =1
GROUP BY i.id
ORDER BY i.id,f.sort_order ASC";

        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        //$rows = $stmt->fetchAll();
        //$json = json_encode($stmt);
        return $stmt;
    }

    public function removeAllItemFields($item_id)
    {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = ' . $item_id);
            $numDeleted = $q->execute();
        }
    }

    public function removeAllIImageItemFields($item_id)
    {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = ' . $item_id . " AND  if.field_name like 'Image List'");
            $numDeleted = $q->execute();
        }
    }

    public function removeAllItemFieldsByFeed($feed_id)
    {
        $feed_id = intval($feed_id);
        if (!empty($feed_id)) {
            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if  where if.feed_id = ' . $feed_id);
            $numDeleted = $q->execute();
        }
    }

    public function setSoldOnAllItemInFeed($feed_id)
    {
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

    public function addView($itemId)
    {

        $sql = "
        UPDATE item
        SET views=COALESCE(views, 0 )+1
        WHERE id=".$itemId;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

    }

    public function findItemByUniqueField($uniqueField, $value)
    {


        if (is_array($value)) {
            return false;
        }
        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i JOIN i.ItemField if WHERE if.field_name=\'' . $uniqueField . '\' and if.field_string_value =\'' . $value . '\'';
        $itemsQuery = $this->getEntityManager()
            ->createQuery($q)->setMaxResults(1);
        //dump($itemsQuery->getOneOrNullResult());
        return $itemsQuery->getOneOrNullResult();
    }

    /**
     * @return bool|mixed
     * Finds items by stock# and VIn
     */
    public function findItemsBy($find,$field='vin')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i');
        if($field=='vin'){
            $qb->Where('i.VIN like :find');
        }else {
            $qb->where('i.stock_nr like :find');
        }

        $qb->setParameter("find", "%" . $find . "%");

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function removeItemsByFeed($feed_id)
    {
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
    public function importRemoteItem($importItem, $mapping, $feed_id, $upload_url, $upload_path, $em)
    {
        //echo "Memory usage in importRemoteItem before: " . (memory_get_usage() / 1024) . " KB" . PHP_EOL . "<br>";

        $feed = $em->getRepository('NumaDOAAdminBundle:Importfeed')->find($feed_id);
        if ($feed instanceof Importfeed) {

        }

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
                //dump($uniqueMapRow->getListingField()->getCaption());
                //dump($uniqueValue);
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

        //seo


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
        //dump($mapping);die();
        foreach ($mapping as $maprow) {
            //dump($maprow->getId());
            $property = $maprow->getSid();

            $processed = false;
            $listingField = false;
            if(!empty($maprow->getFieldSid())) {
                $listingField = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('id' => $maprow->getFieldSid()));

            }
            //dump($listingField);
            //check if there are predefine
                //d listing field in database (listing_field_lists)
            if (!empty($listingField) && !empty($importItem[$property])) {

                $stringValue = $importItem[$property];
                $listingFieldsType = $listingField->getType();

                $itemField = new ItemField();
                $itemField->setAllValues($stringValue, $maprow->getValueMapValues());
                $itemField->setFeedId($feed->getId());


                if ($listingField instanceof Listingfield && !empty($listingField->getId())) {
                    $test = $em->getRepository('NumaDOAAdminBundle:Listingfield')->find($maprow->getListingField()->getId());


                    if ($test instanceof Listingfield) {

                        $itemField->setListingfield($test);
                    }

                    //$itemField->setListingfield($listingFields); //will set caption and type by listing field
                    //$itemField->setFieldName($listingFields->getCaption());
                    //$itemField->setFieldType($listingFields->getType());
                }

                $stringValue = trim($itemField->getFieldStringValue());
                //dump($importItem);
                //dump($property);
                //die();

                //if xml property has children then do each child
                if (!empty($listingFieldsType) && $listingFieldsType == 'list') {
                    $listValues = $listingField->getListingFieldLists();

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

                if (stripos($listingField->getSid(), 'dealer') !== false) {

                    $dealerId = $stringValue;

                    $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('dealer_id' => $dealerId));

                    if ($dealer instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords) {

                        $item->setDealer($dealer);
                    } else {

                        if ($feed->getOnlyMatchedDealers()) {
                            $persist = false;
                            return null;
                        }
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


    public function findByIds($ids)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->andWhere('i.id IN (:ids)')
            ->where("i.id IN(:ids)")
            ->setParameter('ids', array_values($ids));

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function findByFeedId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->where('i.feed_id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function countAllListings($active=1,$sold=0,$category=0,$dealer=false){
        $suffix = "";
        if($dealer instanceof Catalogrecords){
            $suffix .= " and i.dealer_id=".$dealer->getId();
        }
        if(!empty($category)){
            $suffix .= " and i.category_id=".$category;
        }
        $sql = "select count(*) as count from item i WHERE i.active=$active and i.sold=$sold".$suffix;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->execute();
        $res = $stmt->fetch();
        return $res['count'];

    }

    public function countAllViews($active=1,$sold=0,$category=0,$dealer=false){
        $suffix = "";
        if($dealer instanceof Catalogrecords){
            $suffix = " and i.dealer_id=".$dealer->getId();
        }
        if(!empty($category)){
            $suffix .= " and i.category_id=".$category;
        }
        $sql = "select sum(i.views) as count from item i WHERE i.active=$active and i.sold=$sold".$suffix;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->execute();
        $res = $stmt->fetch();
        return $res['count'];

    }

    public function getByCategoryTypeDealer($cat,$type,$dealer=null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->where('i.category_id=:category_id');

        if($cat==1){
            $qb->andWhere('i.body_style like :body_style');
            $qb->setParameter('body_style', $type );
        }else {
            $qb->andWhere('i.type like :type');
            $qb->setParameter('type',  $type );

        }
        $qb->setParameter('category_id', $cat);
        if($dealer instanceof Catalogrecords) {
            $qb->andWhere('i.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer->getId());
        }

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //dump($itemsQuery);
        return $itemsQuery->getResult();
    }

    public function isItemFieldExists($item_id,$fieldName){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:ItemField', 'i')
            ->andWhere('i.field_name=:field_name')
            ->andwhere('i.item_id=:item_id');
        $qb->setParameter('field_name', $fieldName);
        $qb->setParameter('item_id', $item_id);
        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();

        return $itemsQuery->getOneOrNullResult();
    }


}
