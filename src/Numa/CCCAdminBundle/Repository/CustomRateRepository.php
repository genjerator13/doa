<?php

namespace Numa\CCCAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomRateRepository extends EntityRepository
{
    public function removeAllRates($customRateId){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->delete('NumaCCCAdminBundle:CustomRateRate', 'crr')
            //->from('NumaCCCAdminBundle:CustomRateRate', 'crr')
            ->where('crr.custom_rate_id=:crr')
            ->setParameter('crr',$customRateId);
        $qb->getQuery()->execute();
    }

    public function findOneByRatecode($ratecode){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('cr')
            ->from('NumaCCCAdminBundle:CustomRate', 'cr')
            ->Join('NumaCCCAdminBundle:CustomRateValue', 'crv', "WITH", "cr.id=crv.custom_rate_id")
            ->where('crv.name=:ratecode')
            ->setParameter('ratecode',$ratecode);
        $q = $qb->getQuery();
        $res = $q->getResult();
        return $res;
    }

    public function removeAllCustomRateValues($customRateId){
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->delete('NumaCCCAdminBundle:CustomRateValue', 'crv')
            //->from('NumaCCCAdminBundle:CustomRateRate', 'crr')
            ->where('crv.custom_rate_id=:crv')
            ->setParameter('crv',$customRateId);
        $qb->getQuery()->execute();
    }

}
