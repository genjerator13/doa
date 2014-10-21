<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;

class ItemRepository extends EntityRepository {

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
        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i WHERE i.featured = 1 AND i.active=1';
        $query = $this->getEntityManager()->createQuery($q)->setMaxResults($max);
        $res = $query->getResult(); //getOneOrNullResult();
        return $res;
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
                ->add('from', 'NumaDOAAdminBundle:Item i LEFT JOIN i.UserItems ui')
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

    public function removeAllItemFields($item_id) {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = ' . $item_id);
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

    public function findItemByUniqueField($uniqueField, $value) {



        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i JOIN i.ItemField if WHERE if.field_name=\'' . $uniqueField . '\' and if.field_string_value =\'' . $value . '\'';
        $itemsQuery = $this->getEntityManager()
                        ->createQuery($q)->setMaxResults(1);

        //$itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //print_r($value);
        //print_r($uniqueField);
        //
        return $itemsQuery->getOneOrNullResult();
    }

    public function removeItemsByFeed($feed_id) {
        $feed_id = intval($feed_id);
        $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:Item i where i.feed_id = ' . $feed_id);
        $numDeleted = $q->execute();
    }

    public function importRemoteItem($importItem, $mapping, $feed, $upload_url, $upload_path) {
        $em = $this->getEntityManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $uniqueField = $feed->getUniqueField();
        $processed = false;
        $persist = false;

        $uniqueMapRow = $em->getRepository('NumaDOAAdminBundle:Importmapping')->findMapRow($feed->getId(), $uniqueField);

        if (!empty($uniqueField)) {
            $item = $this->findItemByUniqueField($uniqueMapRow->getListingFields()->getCaption(), $importItem[$uniqueField]);
        }
        //\Doctrine\Common\Util\Debug::dump($item);die();

        if (empty($item)) {
            //echo $uniqueMapRow->getListingFields()->getCaption()."....". $importItem[$uniqueField].":::".$uniqueField;
            if ($feed->getPhotoFeed()) {

                return null;
            }
            $persist = true;
            $item = new Item();
            $item->setImportfeed($feed);
        } else {
            
        }

        //clear all item fields if not photo feed
        if (!$feed->getPhotoFeed()) {
            $this->removeAllItemFields($item->getId());
        } else {
            $this->removeAllItemFieldsByFeed($feed->getId());

        }

        foreach ($mapping as $maprow) {
            $property = $maprow->getSid();

            $listingFields = $maprow->getListingFields();
            //check if there are predefined listing field in database (listing_field_lists)

            if (!empty($listingFields) && !empty($importItem[$property])) {
                $stringValue = $importItem[$property];
                $listingFieldsType = $listingFields->getType();

                $itemField = new ItemField();
                $itemField->setAllValues($stringValue, $maprow->getValueMapValues());
                $itemField->setFeedId($feed->getId());
                $itemField->setListingfield($listingFields); //will set caption and type by listing field
                $stringValue = $itemField->getFieldStringValue();

                //if xml property has children then do each child
                if (!empty($listingFieldsType) && $listingFieldsType == 'list') {
                    $listValues = $listingFields->getListingFieldLists();
                    if (!$listValues->isEmpty()) {
                        //get listingFieldlist by ID and stringValue
                        $listingList = $em->getRepository('NumaDOAAdminBundle:ListingFieldLists')->findOneByValue($stringValue, $maprow->getListingFields()->getId());
                        if (!empty($listingList)) {
                            $itemField->setFieldIntegerValue($listingList->getId());
                        }
                    }
                }

                if (!empty($listingFieldsType) && $listingFieldsType == 'array') {
                    $item->proccessImagesFromRemote($stringValue, $maprow, $feed, $upload_path, $upload_url, $em);
                    $processed = true;
                }

                if (!empty($listingFieldsType) && $listingFieldsType == 'options') {
                    $processed = true;
                    $item->proccessOptionsList($stringValue, $feed->getOptionsSeparator());
                }

                if (!$processed) {
                    $item->addItemField($itemField);
                }
                //connect with dealer
                if (strtolower($property) == 'dealerid' || strtolower($property) == 'dealer') {
                    $dealerId = $stringValue;
                    $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findOneBy(array('dealer_id' => $dealerId));
                    $item->setDealer($dealer);
                }
            }
        }//end mapping foreach

/*
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq("fieldName", "Image List"))
        ;
        $images = $item->getItemField()->matching($criteria);
 * 
 */
 
        if ($persist) {
            $em->persist($item);
        }
        return $item;
    }

}
