<?php

namespace Numa\DOAAdminBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class CatalogrecordsRepository extends EntityRepository implements UserProviderInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function xfindByDCategory($dcatId)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('d')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Catalogrecords d')
            ->innerJoin('NumaDOAAdminBundle:DealerCategories', 'dc', "WITH", "d.id=dc.dealer_id")
            ->andWhere("dc.category_id=" . $dcatId);;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findByDealerUsername($username)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('d')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Catalogrecords d')
            ->andWhere("d.username like :username")
            ->setParameter("username", "%" . $username . "%");;
        $query = $qb->getQuery();
        //dump($query);
        return $query->getResult();
    }


    public function isInProgress()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cl')->distinct()
            ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
            ->andWhere('cl.status like :status ')
            ->andWhere('cl.count is not null ')
            ->andWhere('cl.current is not null ')
            ->setParameter('status', "%pending%")
            ->orderBy('cl.id', 'DESC');
        //$qb->getMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function loadUserByUsername($username)
    {

        $user = $this->findOneByUsernameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException('No user found for username ' . $username);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf(
                'Instances of "%s" are not supported.',
                $class
            ));
        }

        if (!$refreshedUser = $this->find($user->getId())) {
            throw new UsernameNotFoundException(sprintf('User with id %s not found', json_encode($user->getId())));
        }

        return $refreshedUser;
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

    public function findOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updatePassword($user, $password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        $qb = $this->createQueryBuilder('d')
            ->update()
            ->set('d.password', ':pass')
            ->where('d.id= :id')
            ->setParameter('pass', $encodedPassword)
            ->setParameter('id', $user->getId());

        return $qb->getQuery()->execute();
    }

    public function updateDmsStatus($dealer_id, $status)
    {
        $sql = "
        UPDATE catalog_records
        SET dms_status='" . $status . "'
        WHERE id=" . $dealer_id;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

    }

    public function getDealerById($dealer_id = null)
    {
        $qb = $this->createQueryBuilder('d');
        if (empty($dealer_id)) {
            $qb->andWhere('d.id is null');
        } else {
            $qb->andWhere('d.id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer_id);
        }
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getDealerByHost($host = null)
    {

        if (empty($host)) {
            return null;
        }
        $nonwww = substr($host, 4, strlen($host));
        //dump($nonwww);die();
        $qb = $this->createQueryBuilder('d');
        $qb->orWhere('d.site_url=:host');
        $qb->orWhere('d.site_url=:hostwww');
        $qb->setParameter('host', $host);
        $qb->setParameter('hostwww', $nonwww);

        return $qb->getQuery()->getOneOrNullResult();

    }

    public function getDealersByDealerGroup($dealer_group_id)
    {

        $qb = $this->createQueryBuilder('d');
        $qb->orWhere('d.dealer_group_id=:dgid');

        $qb->setParameter('dgid', $dealer_group_id);

        return $qb->getQuery()->getResult();

    }


    public function getNonEmptyCoupons($dealer_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Coupon c')
            ->andWhere('c.dealer_id = :dealer_id')
            ->andWhere('c.name <> :name ')
            ->setParameter('dealer_id', $dealer_id)
            ->setParameter('name', "");
        //$qb->getMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findDealerComponents($dealer_id = null)
    {
        //remove /page from $url
        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('dc')
            ->add('from', 'NumaDOADMSBundle:DealerComponent dc');
        if (empty($dealer_id)) {
            $qb->andWhere('dc.dealer_id is null');
        } else {
            $qb->andWhere('dc.dealer_id=:dealer_id');
            $qb->setParameter('dealer_id', $dealer_id);

        }

        $dc = $qb->getQuery()->getResult();


        return $dc;
    }

    public function removeDealer($dealer_id)
    {
        $dealer_id = intval($dealer_id);
        if (!empty($dealer_id)) {

            $this->deleteDealerTable('billing', $dealer_id);

            $this->deleteDealerTable('dealer_categories', $dealer_id);
            $this->deleteDealerTable('coupon', $dealer_id);
            $this->deleteDealerTable('dms_user', $dealer_id);
            $this->deleteDealerTable('email', $dealer_id);

            $this->deleteDealerTable('finance', $dealer_id);
            $this->deleteDealerTable('home_tab', $dealer_id);
            $this->deleteDealerTable('imiage_carousel', $dealer_id);
            $this->deleteDealerTable('dealer_component', $dealer_id);
            //$this->deleteDealerTable('import_feed',$dealer_id);

            $this->deleteDealerTable('listing_form', $dealer_id);


            $this->deleteDealerTable('part_request', $dealer_id);
            $this->deleteDealerTable('service_request', $dealer_id);
            $this->deleteDealerTable('setting', $dealer_id);
            $this->deleteDealerTable('vendor', $dealer_id);
//
            $sql = "DELETE FROM user_item WHERE item_id IN (SELECT id FROM item WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            //
            $sql = "DELETE FROM page_component WHERE page_id IN (SELECT id FROM page WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();

            //
            $sql = "DELETE FROM listing_form WHERE customer_id IN (SELECT id FROM customer WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();

            //
            $sql = "DELETE FROM billing WHERE customer_id IN (SELECT id FROM customer WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            //


            $sql = "UPDATE item set sale_id = NULL where dealer_id=" . $dealer_id;
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM sale WHERE item_id IN (SELECT id FROM item WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM sale WHERE id IN (SELECT sale_id FROM item WHERE dealer_id =" . $dealer_id . ")";
            //dump($sql);
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();


            //dump("item");
            $this->deleteDealerTable('item', $dealer_id);
            $this->deleteDealerTable('import_feed', $dealer_id);
            $this->deleteDealerTable('customer', $dealer_id);
            $this->deleteDealerTable('page', $dealer_id);

            $q = $this->getEntityManager()->createQuery('delete from NumaDOAAdminBundle:CatalogRecords d where d.id = :dealer_id');//' . $dealer_id);
            $q->setParameter("dealer_id",$dealer_id);
            $q->execute();
        }
    }

    public function deleteDealerTable($tablename, $dealer_id)
    {
        $sql = "delete from " . $tablename . " where dealer_id=" . intval($dealer_id);
        //dump($sql);
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
    }

    /**
     * @return array of dealers needed fo kijiji feed
     */
    public function findForKijiji()
    {
        //remove /page from $url
        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('d')
            ->add('from', 'NumaDOAAdminBundle:CatalogRecords d')
            ->andWhere('d.dms_status like :dmsstatus')
            ->andWhere('d.feed_kijiji_manual <> :kijijiManual')
            ->setParameter('dmsstatus', "activated")
            ->setParameter('kijijiManual', 1)
            ->innerJoin('NumaDOAAdminBundle:Item', 'i', "WITH", "d.id=i.dealer_id");

        $dealers = $qb->getQuery()->getResult();


        return $dealers;
    }

}
