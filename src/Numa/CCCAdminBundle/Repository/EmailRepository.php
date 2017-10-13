<?php

namespace Numa\CCCAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EmailRepository extends EntityRepository {

    public function deleteByBatch($batch_id) {

        return $this->getEntityManager()
                        ->createQuery(
                                'DELETE FROM NumaCCCAdminBundle:Email e WHERE e.batch_id= :batchid'
                        )->setParameter('batchid', $batch_id)
                        ->execute();
    }
    
    public function  getNotSendEmails($limit=10,$attachment=false,$batchid=0) {
        $qb = $this->getEntityManager()->createQueryBuilder('e');
        $qb->add('select', 'e')
                ->add('from', 'NumaCCCAdminBundle:Email e')                
                ->where('e.ended_at is null');
        if(!$attachment){
            $qb->andWhere('e.attachment is null OR e.attachment = \'\'');
        }else{
            $qb->andWhere('e.attachment is not null AND NOT e.attachment = \'\'');
        }
        if(!empty($batchid)){
            $qb->andWhere('e.batch_id='.$batchid);
        }
        $query = $qb->getQuery();
        $res = $query->getResult();
        return $res;
    }
    
    public function countNotSendEmails($attachment=false,$batchid=0) {
        $qb = $this->getEntityManager()->createQueryBuilder('e');
        $qb->add('select', 'count(e)')
                ->add('from', 'NumaCCCAdminBundle:Email e')                
                ->where('e.ended_at is null');
        if(!empty($batchid)) {
            $qb->andWhere('e.batch_id='.$batchid);
        }
        if(!$attachment){
            $qb->andWhere('e.attachment is null OR e.attachment = \'\'');
        }else{
            $qb->andWhere('e.attachment is NOT null AND length(e.attachment) >0 ');
        }
        $query = $qb->getQuery();

        $res = $query->getSingleScalarResult();

        return $res;
    }
    
//    public function findSendYesEmailCustomers() {
//        $qb = $this->getEntityManager()
//                ->createQueryBuilder();
//        $qb->select('c,ce')
//                ->from('NumaCCCAdminBundle:Customers','c')
//                ->leftJoin('c.CustomerEmails','ce')
//                ->andWhere('c.sendmail not like :sendmail')
//                ->setParameter('sendmail', "'%n%'")
//        ;
//
//        $query = $qb->getQuery();
//        return $query->getResult();
//    }

}
