<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class CommandLogRepository extends EntityRepository {
    
     /* @param integer $user_id
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    
    public function findLastCommandLog($limit) {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('cl')->distinct()
                ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
                ->orderBy('cl.id','DESC')
                ->getMaxResults($limit);
        ;
            
        $query = $qb->getQuery();
        return $query->getResult();
    }
}

