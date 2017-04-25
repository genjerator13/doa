<?php

namespace Numa\DOAModuleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints\DateTime;

class ComponentRepository extends EntityRepository
{
    public function findByDealerAndId($dealer_id,$component_id)
    {

        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c')
            ->add('from', 'NumaDOAModuleBundle:Component c')
            ->andWhere('c.dealer_id=:dealer_id')
            ->andWhere('c.id=:id')
//            ->andWhere('ad.start_date <= :start_date')
//            ->andWhere('ad.end_date  >=  :end_date')
            ->setParameter('dealer_id', $dealer_id)
            ->setParameter('id', $component_id)
            ->setMaxResults(1);
//            ->setParameter('start_date', $current_date)
//            ->setParameter('end_date', $current_date);

        $query = $qb->getQuery();
        dump($query->getResult());
        die();
        return $query->getResult();
    }

    public function getAllComponentsByDealer($dealer_id)
    {
        $sql = "SELECT c0_.id AS id_0, c0_.page_id AS page_id_1, c0_.name AS name_2, c0_.type AS type_3, c0_.value AS value_4, c0_.settings AS settings_5, c0_.helpdesc AS helpdesc_6, c0_.date_updated AS date_updated_7, c0_.date_created AS date_created_8, c0_.status AS status_9 FROM componentx c0_ INNER JOIN page_component p1_ ON c0_.id = p1_.component_id INNER JOIN page p2_ ON p1_.page_id = p2_.id WHERE p2_.dealer_id LIKE ?";

        $stmt = $this->getEntityManager()->getConnection()->fetchAll($sql);
        return $stmt;
    }

    /**
     * @param $ids
     * Delete Componentx list of ids separated by ,
     */
    public function delete($ids)
    {
        if (!empty($ids)) {

            $qb = $this->getEntityManager()
                ->createQueryBuilder()
                ->delete('NumaDOAModuleBundle:Component', 'c')
                ->where('c.id in (' . $ids . ")");
            $qb->getQuery()->execute();
        }
    }

    public function findDealerComponentByDealerId($dealer)
    {
        $dealer_id = $dealer;
        $theme="";
        if($dealer instanceof Catalogrecords){
            $dealer_id = $dealer->getId();
            $theme=$dealer->getSiteTheme();
        }
        $qb = $this->getEntityManager()
            ->createQueryBuilder();

        $qb->select('dc')
            ->add('from', 'NumaDOADMSBundle:DealerComponent dc')
            ->andWhere('dc.dealer_id like :dealer_id');
        if(!empty($theme)) {
            $qb->andWhere('dc.theme=:theme OR dc.theme IS NULL');
            $qb->setParameter('theme', $dealer->getSiteTheme());
        }
        $qb->setParameter('dealer_id', $dealer->getId());

        $components = $qb->getQuery()->getResult();

        return $components;
    }

}