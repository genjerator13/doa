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

class ItemFieldRepository extends EntityRepository
{
    public function getLocalImages()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('if')
            ->from('NumaDOAAdminBundle:ItemField', 'if')
            ->Where("if.field_name like 'Image List'")
            ->andWhere("if.field_string_value not like 'http://%'");
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }
}
