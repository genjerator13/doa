<?php

namespace Numa\DOAAdminBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\User;
use Numa\DOAModuleBundle\Entity\Component;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\Util\Component\ComponentEntityInterface;

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
        } else {
            $qb->andWhere('ic.dealer_id is null');
        }
        $qb->andWhere('ic.component_id is null');
        $query = $qb->getQuery();
        $res = $query->getResult(); //->getResult();
        return $res;
    }

    public function findByComponent(ComponentEntityInterface $component)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ic')
            ->from('NumaDOAAdminBundle:ImageCarousel', 'ic');

        if ($component instanceof Component) {

            $qb->Where('ic.component_id = :component_id');
        }elseif($component instanceof DealerComponent){
            $qb->Where('ic.dealer_component_id = :component_id');
        }
        $qb->setParameter("component_id", $component->getId());

        $query = $qb->getQuery();

        $res = $query->getResult(); //->getResult();
        $res = new ArrayCollection($res);
        return $res;
    }

//    public function findByDealerComponent($component_id)
//    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        $qb->select('ic')
//            ->from('NumaDOAAdminBundle:ImageCarousel', 'ic');
//
//
//        $qb->Where('ic.dealer_component_id like :component_id');
//        $qb->setParameter("component_id", $component_id);
//
//        $query = $qb->getQuery();
//        //dump($query);die();
//        $res = $query->getResult(); //->getResult();
//        return $res;
//    }
}
