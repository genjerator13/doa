<?php

namespace Numa\DOADMSBundle\Repository;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

class SaleRepository extends EntityRepository {
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOADMSBundle:Sale', 's')
                ->where('s.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }
}