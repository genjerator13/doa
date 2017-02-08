<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PageComponentRepository extends EntityRepository
{
    /**
     * @param $ids
     * Delete Componentx list of ids separated by ,
     */
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOAModuleBundle:PageComponent', 'pc')
                ->where('pc.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

}