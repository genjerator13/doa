<?php

namespace Numa\DOAAdminBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

class CatalogrecordsRepository extends EntityRepository implements UserProviderInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function xfindByDCategory($dcatId)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('d')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Catalogrecords d')
            ->innerJoin('NumaDOAAdminBundle:DealerCategories', 'dc', "WITH", "d.id=dc.dealer_id")
            ->andWhere("dc.category_id=" . $dcatId);;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findByDealerUsername($username)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('d')->distinct()
            ->add('from', 'NumaDOAAdminBundle:Catalogrecords d')
            ->andWhere("d.username like :username")
            ->setParameter("username", "%" . $username . "%");;
        $query = $qb->getQuery();
        //dump($query);
        return $query->getResult();
    }


    public function isInProgress()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('cl')->distinct()
            ->add('from', 'NumaDOAAdminBundle:CommandLog cl')
            ->andWhere('cl.status like :status ')
            ->andWhere('cl.count is not null ')
            ->andWhere('cl.current is not null ')
            ->setParameter('status', "%pending%")
            ->orderBy('cl.id', 'DESC');
        //$qb->getMaxResults(1);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function loadUserByUsername($username)
    {

        $user = $this->findOneByUsernameOrEmail($username);

        if (!$user) {
            throw new UsernameNotFoundException('No user found for username ' . $username);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf(
                'Instances of "%s" are not supported.',
                $class
            ));
        }

        if (!$refreshedUser = $this->find($user->getId())) {
            throw new UsernameNotFoundException(sprintf('User with id %s not found', json_encode($user->getId())));
        }

        return $refreshedUser;
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
        || is_subclass_of($class, $this->getEntityName());
    }

    public function findOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function updatePassword($user, $password)
    {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        $qb = $this->createQueryBuilder('d')
            ->update()
            ->set('d.password', ':pass')
            ->where('d.id= :id')
            ->setParameter('pass', $encodedPassword)
            ->setParameter('id', $user->getId());

        return $qb->getQuery()->execute();
    }
    public function updateDmsStatus($dealer_id, $status)
    {
        $sql = "
        UPDATE catalog_records
        SET dms_status='".$status."'
        WHERE id=".$dealer_id;

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

    }


}
