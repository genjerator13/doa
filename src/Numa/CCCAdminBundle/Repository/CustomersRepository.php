<?php

namespace Numa\CCCAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomersRepository extends EntityRepository  implements UserProviderInterface, UserLoaderInterface
{

    public function findOneByCustCode($custcode)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM CCCAdminBundle:Customers c WHERE c.cust_code= :custcode'
            )->setParameter('custcode', $custcode)
            ->getOneOrNullResult();
    }

    public function findSendYesEmailCustomers()
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c,ce')
            ->from('NumaCCCAdminBundle:Customers', 'c')
            ->innerJoin('c.CustomerEmails', 'ce')
            ->andWhere('c.sendmail not like :sendmail')
            ->setParameter('sendmail', "'%y%'");

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findCustomersByIds($ids)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c')
            ->from('NumaCCCAdminBundle:Customers', 'c')
            ->andWhere('c.id IN (:ids)')
            ->setParameter('ids', $ids);;

        $query = $qb->getQuery();

        return $query->getArrayResult();
    }

    public function getAllCustomerNamesArray($field = "name")
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c.id,c.custcode,c.name,c.custsurchargerate,c.ratelevel')
            ->from('NumaCCCAdminBundle:Customers', 'c');

        $query = $qb->getQuery();

        $res = $query->getArrayResult();

        $res = array_map(function ($a) use ($field) {
            if($field=="name") {
                return "{id:".$a['id'].", label:\"" . htmlspecialchars($a[$field]) . " (" . $a['custcode'] . ")" . "\",custcode:\"".$a['custcode']."\",custsurchargerate:\"".$a['custsurchargerate']."\",ratelevel:\"".$a['ratelevel']."\"}";
            }
                return "{id:".$a['id'].", label:\"" . htmlspecialchars($a[$field]) . "\",custcode:\"".$a['custcode']."\",name:\"" . htmlspecialchars($a['name']) . " (" . $a['custcode'] . ")" . "\"}";
        }, $res);
        $res=implode(",",$res);
        return $res;
    }

    public function findSendYesEmailCustomersInProbills()
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('c,ce')
            ->from('NumaCCCAdminBundle:Customers', 'c')
            ->join('c.probills', 'p')
            ->leftJoin('c.CustomerEmails', 'ce')
            ->andWhere('c.sendmail not like :sendmail')
            ->setParameter('sendmail', "'%n%'");

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

    public function findOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.username = :username')
            ->andWhere('c.activate IS NULL OR c.activate=1')
            ->setParameter('username', $username)

            ->getQuery()
            ->getOneOrNullResult();
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

}
