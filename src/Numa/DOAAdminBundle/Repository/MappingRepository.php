<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Entity\Listingfield;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class MappingRepository extends EntityRepository
{

    /* @param integer $feed_id
     * @param string  $remoteProperty
     * @return \Numa\DOAAdminBundle\Entity\Item
     */

    public function findMapRow($feed_id, $remoteProperty)
    {
        $feed_id = intval($feed_id);
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('m')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Importmapping m')
            ->where('m.feed_sid=:feed_id')
            ->andWhere('m.property = :property')
            ->setParameter('feed_id', $feed_id)
            ->setParameter('property', $remoteProperty )
            ->setMaxResults(1);

        $itemsQuery = $qb->getQuery(); //getOneOrNullResult();
        //\Doctrine\Common\Util\Debug::dump($feed_id);
        //\Doctrine\Common\Util\Debug::dump($remoteProperty);
        //\Doctrine\Common\Util\Debug::dump($itemsQuery->getSQL());die();
        //dump($itemsQuery);
        //dump($itemsQuery->getOneOrNullResult());
        return $itemsQuery->getOneOrNullResult();
    }

    public function resetMappings($feedId)
    {
        $feedId = intval($feedId);
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->delete('m')
            ->add('from', 'NumaDOAAdminBundle:Importmapping m')
            ->where('m.feed_sid=:feed_id')
            ->setParameter('feed_id', $feedId);

        $itemsQuery = $qb->getQuery();
        $itemsQuery->execute();
    }
}

