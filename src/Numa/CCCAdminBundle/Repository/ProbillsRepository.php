<?php

namespace Numa\CCCAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProbillsRepository extends EntityRepository {

    public function findAllByCustomer($customer, $batchid = 0, $searchText = '') {
        $cid = $customer;
        if ($customer instanceof \Numa\CCCAdminBundle\Entity\Customers) {
            $cid = $customer->getId();
        }
        $qb = $this->createQueryBuilder('p')
                ->where('p.customersId = :custcode')
                ->setParameter('custcode', $cid)
                ->orderBy('p.pDate', 'ASC');
        if (!empty($batchid)) {
            $qb->andWhere('p.batchX= :batchX');
            $qb->setParameter('batchX', $batchid);
        }
        if (!empty($searchText)) {
            $qb->andWhere('p.waybill like :waybill');
            $qb->setParameter('waybill', "%" . $searchText . "%");
        }
        $query = $qb->getQuery();
        return $query;
    }

    /**
     * Returns all probill for a batch
     * @param int $batch
     * @return type Array of Probills
     */
    public function findAllByBatch($batchid, $searchText = '') {

        $qb = $this->createQueryBuilder('p')
                ->orderBy('p.pDate', 'ASC');
        if ($batchid>0) {
            $qb->andWhere('p.batchX= :batchX');
            $qb->setParameter('batchX', $batchid);
        }
        if (!empty($searchText)) {
            $qb->andWhere('p.waybill like :waybill');
            $qb->setParameter('waybill', "%" . $searchText . "%");
        }
        return $qb->getQuery();
    }

    /**
     * 
     * @param int $batchid
     * @return type array of customers found in requested batch
     */
    public function findAllCustomersInBatch($batchid) {
        $query = $this->getEntityManager()
                        ->createQuery(
                                'SELECT c FROM  NumaCCCAdminBundle:Customers c '
                                . ' JOIN c.probills p'
                                . ' WHERE p.batchX= :batchX'
                                . ' GROUP BY c.custcode'
                                . ' ORDER BY c.custcode'
                        )->setParameter('batchX', $batchid);


        return $query->getResult();
    }
    
    public function getProbils($batchid=0,$customer=0){
        
        $qb = $this->createQueryBuilder('p')
                
                
                ->orderBy('p.Customer', 'ASC')
                ->orderBy('p.dept', 'ASC')
                ->orderBy('p.pDate', 'ASC');
        if(!empty($customer)){
            $qb->where('p.customersId = :custcode')
                ->setParameter('custcode', $customer)   ;
        }
        if ($batchid>0) {
            $qb->andWhere('p.batchX= :batchX');
            $qb->setParameter('batchX', $batchid);
        }
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getTotals(array $results,$discount=0) {
        $total = 0;
        $custSurchargeAMT = 0;
        $subtotal = 0;
        $gstAMT = 0;
        $balance = 0;
        $invoice = "";
        $totalDiscount=0;
        $balanceDiscount=0;
        $subtotalDiscount=0;


        foreach ($results as $key => $res) {
            $total = $total + $res->getTotal();
            $custSurchargeAMT = $custSurchargeAMT + $res->getCustSurchargeAMT();
            $subtotal = $subtotal + $res->getSubtotal();
            $gstAMT = $gstAMT + $res->getGstAMT();
            $invoice = $res->getInvoice();
        }

        $balance = $total + $custSurchargeAMT + $gstAMT;
        if($discount>0){
            $totalDiscount=$total;
            $subtotalDiscount =  $subtotal*$discount;
            $balanceDiscount = ($subtotal-$subtotalDiscount)  + $gstAMT;
            $subtotalDiscount =  $subtotal*$discount;
        }

        $res = array('total' => $total,
            'custSurchargeAMT' => $custSurchargeAMT,
            'subtotal' => $subtotal,
            'gstAMT' => $gstAMT,
            'balance' => $balance,
            'invoice' => $invoice,
            'totalDiscount' => $totalDiscount,
            'balanceDiscount' => $balanceDiscount,
            'subtotalDiscount' => $subtotalDiscount,
        );


        return $res;
        ;
    }

}
