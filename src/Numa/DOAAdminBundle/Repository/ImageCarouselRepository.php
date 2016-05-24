<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;

class ImageCarouselRepository extends EntityRepository
{


    public function findByDealers($user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ic')
            ->from('NumaDOAAdminBundle:ImageCarousel', 'ic');

        if ($user instanceof Catalogrecords) {
            $qb->Where('ic.dealer_id like :dealer_id');

            $qb->setParameter("dealer_id", $user->getId());
        }else{
            $qb->andWhere('ic.dealer_id is null');
        }
        $qb->andWhere('ic.component_id is null');
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function findByComponent($component_id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ic')
            ->from('NumaDOAAdminBundle:ImageCarousel', 'ic');


        $qb->Where('ic.component_id like :component_id');
        $qb->setParameter("component_id", $component_id);

        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }
}
