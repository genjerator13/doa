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
                ->orderBy('cl.id', 'DESC')
                ->getMaxResults($limit);
        ;

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getCommandsByStatus($status='pending',$limit=0) {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('cl')->distinct()
                ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
                ->andWhere('cl.status like :status')
                ->setParameter('status', "%" . $status . "%")
                ->orderBy('cl.id', 'DESC');
        
        if(!empty($limit)){
            $qb->getMaxResults($limit);
        }

        $query = $qb->getQuery();

        return $query->getResult();
    }
    
    public function isInProgress() {
        $qb = $this->getEntityManager()
                ->createQueryBuilder();
        $qb->select('cl')->distinct()
                ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
                ->andWhere('cl.status like :status ')
                ->andWhere('cl.count is not null ')
                ->andWhere('cl.current is not null ')
                ->setParameter('status', "%started%")
                ->orderBy('cl.id', 'DESC');
        $qb->getMaxResults(1);
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }
    
    public function getPendingCommands($limit=0){
        return $this->getCommandsByStatus('pending');
    }

}
