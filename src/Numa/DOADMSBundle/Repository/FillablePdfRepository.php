<?php

namespace Numa\DOADMSBundle\Repository;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class FillablePdfRepository extends EntityRepository {


    public function findByState(Catalogrecords $dealer)
    {
        return $this->createQueryBuilder('f')

            ->andWhere('f.state=:state')
            ->setParameter('state', $dealer->getState())

            ->getQuery()
            ->getResult();
    }


}