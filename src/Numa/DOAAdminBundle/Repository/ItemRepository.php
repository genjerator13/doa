<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Importfeed;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Numa\DOADMSBundle\Entity\DealerGroup;
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

        $q = 'SELECT i FROM ItemField WHERE i.item_id=:item_id';//. $item_id;
        $query = $this->getEntityManager()
            ->createQuery($q);
        $query->setParameter("item_id", $item_id);
        $res = $query->getResult();
        return $res;
    }

    public function findFeatured($dealer_id = "", $max = 5)
    {
        if (empty($max)) {
            $max = 5;
        }

        $dealer_id = empty($dealer_id) ? "" : $dealer_id;
        $res2 = $this->memcache->get('featured_' . $dealer_id);

        if (!$res2) {
            //$q = 'SELECT i  FROM NumaDOAAdminBundle:item i WHERE i.featured=1 AND i.active=1 and i.archive_status is NULL or i.archive_status<>"' . Item::archived . '"';
            $q = 'SELECT i  FROM NumaDOAAdminBundle:item i WHERE i.featured=1 AND i.active=1' ;
            if (!empty($dealer_id)) {
                $q = $q . " AND i.dealer_id=" . intval($dealer_id);
            }
            $query = $this->getEntityManager()
                ->createQuery($q);
            // $query->useResultCache(true, 3600, 'featuredSelect_'.$dealer_id);

            $res2 = $query->getArrayResult();
            $this->memcache->set('featured_' . $dealer_id, $res2);
        }

        $count = count($res2);
        $maxOffset = $count - $max <= 0 ? $count : $max;

        if (!empty($res2)) {

            $rand_keys = array_rand($res2, $maxOffset);

            $randResult = array();
            if (!empty($rand_keys)) {
                foreach ($rand_keys as $key) {
                    $randResult[] = $res2[$key]['id'];
                }

                $qb = $this->getEntityManager()->createQueryBuilder();
                $qb->select('i')
                    ->from('NumaDOAAdminBundle:Item', 'i')
                    ->andWhere('i.id IN (:ids)')
                    ->setParameter('ids', $randResult)
                    ->setMaxResults(10);;
                if (!empty($dealer_id)) {
                    $qb->andWhere('i.dealer_id=:dealer_id');
                    $qb->setParameter('dealer_id', intval($dealer_id));
                }

                $query = $qb->getQuery();
                $query->useResultCache(true, 3600, 'featuredRandomSet');

                $res = $query->getResult(); //->getResult();

                return $res;
            }
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

        $itemsQuery = $qb->getQuery();
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
            }
        }

        $itemsQuery = $qb->getQuery();
        return $itemsQuery->getResult();
    }

    public function getItemByDealerAndCategory($dealer_id, $category = null, $sold = null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i');
        if (empty($dealer_id)) {

        } elseif (is_numeric($dealer_id)) {
            $qb->where('i.dealer_id=:dealer');
            $qb->setParameter('dealer', $dealer_id);
        } elseif (is_string($dealer_id)) {
            $qb->Join("NumaDOAAdminBundle:Catalogrecords", "d", 'WITH', 'i.dealer_id=d.id');
            $qb->andWhere("d.username like :dealer");
            $qb->setParameter("dealer", $dealer_id);
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
        $qb->andWhere('i.archive_status is NULL or i.archive_status<>\'' . Item::archived . '\'');
        if ($sold !== null) {
            $qb->andWhere("i.sold=:sold");
            $qb->setParameter("sold", $sold);
        }
        $itemsQuery = $qb->getQuery()->useResultCache(true);

        return $itemsQuery->getResult();
    }

    public function getItemByDealerGroupAndCategory($dealer_group_id, $category = null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i');
        if (empty($dealer_group_id)) {

        } elseif (is_numeric($dealer_group_id)) {
            $qb->Join("NumaDOAAdminBundle:Catalogrecords", "d", 'WITH', 'i.dealer_id=d.id');
            $qb->andWhere("d.dealer_group_id like :dealer_group_id");
            $qb->setParameter("dealer_group_id", $dealer_group_id);
        }

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
        $qb->andWhere('i.archive_status is NULL or i.archive_status<>\'' . Item::archived . '\'');


        $itemsQuery = $qb->getQuery()->useResultCache(true);

        return $itemsQuery->getResult();
    }

    public function getItemByDealerUsernameAndCategory($dealer_id, $category = null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')->distinct()
            ->from('NumaDOAAdminBundle:Item', 'i');
        if (!empty($dealer_id)) {
            $qb->Join("NumaDOAAdminBundle:Catalogrecords", "d", 'WITH', 'i.dealer_id=d.id');
            $qb->andWhere("d.username like :dealer");
            $qb->setParameter("dealer", $dealer_id);
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
        $qb->andWhere("i.active=1")
            ->andWhere('i.archive_status is NULL or i.archive_status<>\'' . Item::archived . '\'');

        $itemsQuery = $qb->getQuery()->useResultCache(true);

        return $itemsQuery->getResult();
    }


    public function getAllListings($dealer_id = null)
    {

        $dealers = $dealer_id;
        if (is_array($dealer_id)) {
            $dealers = implode(",", $dealer_id);
        }

        $sql = "SELECT DISTINCT i. * , i.cover_photo as photo,c.name as category, s.invoice_nr as saleInvoiceNr, s.invoice_date as saleInvoiceDate, s.invoice_amt as saleInvoiceAmt, s.total_unit_cost as saleTotalUnitCost, s.selling_price as saleSellingPrice FROM item AS i left JOIN category c ON i.category_id = c.id LEFT JOIN sale s ON i.sale_id = s.id WHERE i.archive_status <> 'archived' or i.archive_status is null GROUP BY i.id ORDER BY i.id DESC";
        if (!empty($dealer_id)) {
            $sql = "SELECT DISTINCT i. * , i.cover_photo as photo,c.name as category, s.invoice_nr as saleInvoiceNr, s.invoice_date as saleInvoiceDate, s.invoice_amt as saleInvoiceAmt, s.total_unit_cost as saleTotalUnitCost, s.selling_price as saleSellingPrice FROM item AS i left JOIN category c ON i.category_id = c.id LEFT JOIN sale s ON i.sale_id = s.id WHERE i.dealer_id in (" . $dealers . ") AND (i.archive_status <> 'archived' or i.archive_status is null) GROUP BY i.id ORDER BY i.id DESC";
        }

        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }

    public function getAllSingleColumn($columnName, $dealer = null, $order = "ASC")
    {

        $sql = "SELECT DISTINCT i." . $columnName . " from item i WHERE i." . $columnName . " IS NOT NULL ORDER BY " . $columnName . " " . $order;
        if ($dealer instanceof Catalogrecords) {
            $sql = "SELECT DISTINCT i." . $columnName . " from item i where dealer_id=" . intval($dealer->getId()) . " AND i." . $columnName . " IS NOT NULL ORDER BY " . $columnName . " " . $order;
        }
        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }

    public function getAllmake($dealer = null, $order = "ASC")
    {

        $sql = "SELECT DISTINCT i.make, lft.id FROM item i JOIN listing_field_tree lft ON i.make = lft.name ORDER BY make " . $order;
        if ($dealer instanceof Catalogrecords) {
            $sql = "SELECT DISTINCT i.make, lft.id FROM item i JOIN listing_field_tree lft ON i.make = lft.name WHERE dealer_id=" . intval($dealer->getId()) . " ORDER BY make " . $order;
        }
        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }


    public function removeAllItemFields($item_id)
    {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = :item_id');
            $q->setParameter("item_id", $item_id);
            $numDeleted = $q->execute();
        }
    }

    public function removeAllIImageItemFields($item_id)
    {
        $item_id = intval($item_id);
        if (!empty($item_id)) {

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if where if.item_id = :item_id AND  if.field_name like "Image List"');
            $q->setParameter("item_id", $item_id);
            $numDeleted = $q->execute();
        }
    }

    public function removeAllItemFieldsByFeed($feed_id)
    {
        $feed_id = intval($feed_id);
        if (!empty($feed_id)) {
            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:ItemField if  where if.feed_id = :feed_id');
            $q->setParameter("feed_id", $feed_id);
            $q->execute();
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
        WHERE id=" . $itemId;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

    }

    public function findItemByUniqueField($uniqueField, $value)
    {


        if (is_array($value)) {
            return false;
        }
        $q = 'SELECT i FROM NumaDOAAdminBundle:Item i JOIN i.ItemField if WHERE if.field_name=:uniquefield and if.field_string_value =:value';
        $itemsQuery = $this->getEntityManager()
            ->createQuery($q)
            ->setParameter("uniquefield", $uniqueField)
            ->setParameter("value", $value)
            ->setMaxResults(1);
        return $itemsQuery->getOneOrNullResult();
    }

    /**
     * @return bool|mixed
     * Finds items by stock# and VIn
     */
    public function findItemsByUnique($find, $field = 'vin', $dealer_ids = "")
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i');
        if ($field == 'vin') {
            $qb->Where('i.VIN like :find');
        } else {
            $qb->where('i.stock_nr like :find');
        }
        if (!empty($dealer_ids)) {
            $qb->andWhere('i.dealer_id IN (:dealer_ids)')
                ->setParameter('dealer_ids', $dealer_ids);;
        }

        $qb->setParameter("find", "%" . $find . "%");

        $qb->andWhere('i.sold <> 1');

        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }

    public function removeItemsByFeed($feed_id)
    {
        $feed_id = intval($feed_id);
        $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:Item i where i.feed_id = :feed_id')
            ->setParameter("feed_id", $feed_id);
        $q->execute();
    }

    /**
     * Imports single remote listing(Item)
     * @param array $importItem (array remote Item)
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
        if(empty($importItem[$uniqueField])){
            return;
        }
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

        foreach ($mapping as $maprow) {
            //dump($maprow->getId());
            $property = $maprow->getSid();

            $processed = false;
            $listingField = false;
            if (!empty($maprow->getFieldSid())) {
                $listingField = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('id' => $maprow->getFieldSid()));

            }

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
                }

                $stringValue = trim($itemField->getFieldStringValue());

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
        $paramIds = $ids;
        if (!is_array($ids)) {
            $paramIds = explode(",", $ids);
        }

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->andWhere('i.id IN (:ids)')
            ->setParameter('ids', $paramIds);

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

    public function countAllListings($active = 1, $sold = 0, $category = 0, $dealer = false)
    {
        $suffix = "";
        if ($dealer instanceof Catalogrecords) {
            $suffix .= " and i.dealer_id=" . $dealer->getId();
        }

        if (!empty($category)) {
            $suffix .= " and i.category_id=" . $category;
        }
        //->andWhere('i.archive_status is NULL or i.archive_status<>"archived')

        $sql = "select count(*) as count from item i WHERE (i.archive_status is NULL or i.archive_status<>'" . Item::archived . "') and i.active=$active and i.sold=$sold" . $suffix;
        if ($dealer instanceof DealerGroup) {
            $sql = "select count(*) as count from item i left join catalog_records d ON d.id = i.dealer_id WHERE (i.archive_status is NULL or i.archive_status<>'" . Item::archived . "') and d.dealer_group_id=" . $dealer->getId() . " and i.active=$active and i.sold=$sold" . $suffix;
        }

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->execute();
        $res = $stmt->fetch();
        return $res['count'];

    }

    public function countAllViews($active = 1, $sold = 0, $category = 0, $dealer = false)
    {
        $suffix = "";
        if ($dealer instanceof Catalogrecords) {
            $suffix = " and i.dealer_id=" . $dealer->getId();
        }
        if (!empty($category)) {
            $suffix .= " and i.category_id=" . $category;
        }
        $sql = "select sum(i.views) as count from item i WHERE i.active=$active and i.sold=$sold" . $suffix;
        if ($dealer instanceof DealerGroup) {
            $sql = "select sum(i.views) as count from item i left join catalog_records d ON d.id = i.dealer_id WHERE d.dealer_group_id=" . $dealer->getId() . " and i.active=$active and i.sold=$sold" . $suffix;
        }

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->execute();
        $res = $stmt->fetch();
        return $res['count'];

    }

    public function getByCategoryTypeDealer($cat, $type, $dealer = null)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->where('i.category_id=:category_id');

        if ($cat == 1) {
            $qb->andWhere('i.body_style like :body_style');
            $qb->setParameter('body_style', $type);
        } elseif ($cat == 13) {
            $qb->andWhere('i.ag_application like :ag_application');
            $qb->setParameter('ag_application', $type);
        } else {
            $qb->andWhere('i.type like :type');
            $qb->setParameter('type', $type);

        }
        $qb->setParameter('category_id', $cat);
        if ($dealer instanceof Catalogrecords) {
            $qb->andWhere('i.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer->getId());
        }

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //dump($itemsQuery);
        return $itemsQuery->getResult();
    }

    public function isItemFieldExists($item_id, $fieldName)
    {
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

    public function setCoverPhoto($item_id, $src)
    {
        if (!empty($item_id)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('NumaDOAAdminBundle:Item', 'i')
                ->set('i.cover_photo', "'" . $src . "'")
                ->where('i.id=' . $item_id);
            $qb->getQuery()->execute();
        }
    }

    public function getCoverPhoto($item_id)
    {
        $item_id = intval($item_id);
        $sql = "select * from item_field where item_field.field_name = \"Image List\" and item_field.item_id=$item_id order by item_field.sort_order";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $res = $stmt->execute();
        $res = $stmt->fetch();
        if (!empty($res['field_string_value'])) {
            return $res['field_string_value'];
        }
        return "";
    }

    /**
     * @param $ids
     * @param $active
     * Activate or deactivate (depends by $active param) list of ids separated by ,
     */
    public function activate($ids, $active = true)
    {
        if (!empty($ids)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('NumaDOAAdminBundle:Item', 'i')
                ->set('i.active', $active)
                ->where('i.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    /**
     * @param $ids
     * @param $active
     * Activate or deactivate (depends by $active param) list of ids separated by ,
     */
    public function makeFeatured($ids, $featured = true)
    {
        if (!empty($ids)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('NumaDOAAdminBundle:Item', 'i')
                ->set('i.featured', $featured)
                ->where('i.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    /**
     * @param $ids
     * Activate or deactivate (depends by $active param) list of ids separated by ,
     */
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOAAdminBundle:Item', 'i')
                ->where('i.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    public function generateCoverPhotos()
    {
        $sql = " SELECT item.id FROM item JOIN item_field ON item.id = item_field.item_id WHERE item_field.field_name LIKE \"Image List\" group by item.id order by item_field.sort_order";
        $sql = "UPDATE item i JOIN (
SELECT field_string_value, item_id
FROM item_field
WHERE field_name LIKE '%Image List%'
ORDER BY sort_order
)iif ON i.id = iif.item_id
SET i.cover_photo = iif.field_string_value";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt;
        //$stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        //return $stmt;


    }

    public function updateCoverPhoto($item_id)
    {
        $sql = "UPDATE item SET item.cover_photo = ( SELECT item_field.field_string_value FROM item_field WHERE item_field.field_name LIKE \"Image List\" and item_field.item_id=$item_id  order by item_field.sort_order LIMIT 1)";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }


    public function getCoverPhoto2($item_id)
    {
        $sql = " SELECT item_field.field_string_value FROM item_field WHERE item_field.field_name LIKE \"Image List\" and item_field.item_id=$item_id order by item_field.sort_order LIMIT 1";
        //$sql = "UPDATE item JOIN item_field ON item.id = item_field.item_id SET item.cover_photo = item_field.field_string_value WHERE item_field.field_name LIKE \"Image List\" ";
//UPDATE item SET item.cover_photo = ( SELECT item_field.field_string_value FROM item_field WHERE item_field.field_name LIKE "Image List"  order by item_field.sort_order LIMIT 1)
        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        if (!empty($stmt[0]['field_string_value'])) {
            return $stmt[0]['field_string_value'];
        }
        return null;
    }

    /**
     * @return QueryBuilder
     * needed for elasti search
     */
    public function createIsActiveNonDeletedQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->andWhere('i.active=1')
            ->andWhere('i.archive_status is NULL or i.archive_status<>\'' . Item::archived . '\'')
            ->orderBy('i.id', 'DESC');

        return $queryBuilder;
    }

    public function findByDate($date, $date1, $dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->Where('i.dealer_id IN (' . $dealer_id . ')')
            ->andWhere('i.active=1')
            ->andWhere('i.archive_status is NULL or i.archive_status<>\'' . Item::archived . '\'')
            ->andWhere('i.sold=0');

        if (!empty($date) && empty($date1)) {
            $qb->andWhere('i.date_created > :date')
                ->setParameter("date", $date);
        }
        if (empty($date) && !empty($date1)) {
            $qb->andWhere('i.date_created < :date1')
                ->setParameter("date1", $date1);
        }
        if (!empty($date) && !empty($date1)) {
            $qb->andWhere('i.date_created BETWEEN :date AND :date1')
                ->setParameter("date", $date)
                ->setParameter("date1", $date1);
        }

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();

        return $res;
    }

    /**
     * @return QueryBuilder
     * needed for elasti search
     */

    public function findSoldForArchive($period = '-60 days')
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from('NumaDOAAdminBundle:Item', 'i')
            ->Where('i.archive_status <> :archiveStatus or i.archive_status is null')
            ->setParameter("archiveStatus", 'archived')
            ->andWhere('i.archived_date IS NULL')
            ->andWhere('i.sold = 1')
            ->andWhere('i.sold_date IS NOT NULL')
            ->andWhere('i.sold_date < :date')
            ->setParameter("date", new \DateTime($period));

        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }

    public function getAllArchivedListings($dealer_id = null)
    {

        $dealers = $dealer_id;
        if (is_array($dealer_id)) {
            $dealers = implode(",", $dealer_id);
        }

        $sql = "SELECT DISTINCT i. * , i.cover_photo as photo,c.name as category, s.invoice_nr as saleInvoiceNr, s.invoice_date as saleInvoiceDate, s.invoice_amt as saleInvoiceAmt, s.total_unit_cost as saleTotalUnitCost, s.selling_price as saleSellingPrice FROM item AS i left JOIN category c ON i.category_id = c.id LEFT JOIN sale s ON i.sale_id = s.id WHERE i.archive_status like 'archived' GROUP BY i.id ORDER BY i.id DESC";
        if (!empty($dealer_id)) {
            $sql = "SELECT DISTINCT i. * , i.cover_photo as photo,c.name as category, s.invoice_nr as saleInvoiceNr, s.invoice_date as saleInvoiceDate, s.invoice_amt as saleInvoiceAmt, s.total_unit_cost as saleTotalUnitCost, s.selling_price as saleSellingPrice FROM item AS i left JOIN category c ON i.category_id = c.id LEFT JOIN sale s ON i.sale_id = s.id where i.dealer_id in (" . $dealers . ") AND i.archive_status like 'archived' GROUP BY i.id ORDER BY i.id DESC";
        }

        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }

    /**
     * @param $ids
     * Recover Item list of ids separated by ,
     */
    public function recover($ids, $archiveStatus = "recovered")
    {
        if (!empty($ids)) {
            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->update('NumaDOAAdminBundle:Item', 'i')
                ->set('i.sold', 'false')
                ->set('i.sold_date', 'null')
                ->set('i.archive_status', '?1')
                ->setParameter(1, $archiveStatus)
                ->set('i.archived_date', 'null')
                ->where('i.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

}
