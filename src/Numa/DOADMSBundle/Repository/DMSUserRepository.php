<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 4.9.15.
 * Time: 11.37
 */

namespace Numa\DOADMSBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\DMSUser;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DMSUserRepository extends EntityRepository implements UserLoaderInterface, UserProviderInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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
        global $kernel;
        if ($kernel instanceOf \AppCache) $kernel = $kernel->getKernel();
        $host = $kernel->getContainer()->get('numa.dms.user')->getCurrentSiteHost();

        $one = $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
        if ($one instanceof DMSUser) {
            $dealer = $one->getDealer();


            if ($dealer instanceof Catalogrecords) {
                $dealer_host = $dealer->getSiteUrl();

                if (strpos($dealer_host, $host) !== false || strpos($host, $dealer_host) !== false) {

                    return $one;
                }
            }
        }
        return null;
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

    public function findByDealerGroupId($dealer_group_id)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        $qb->select('user')
            ->add('from', 'NumaDOADMSBundle:DMSUser user')
            ->innerJoin('NumaDOAAdminBundle:Catalogrecords', 'd', "WITH", "d.id=user.dealer_id")
            ->where("d.dealer_group_id=:dealer_group_id")
//            ->andWhere("user.status NOT LIKE 'deleted' OR user.status IS NULL")
            ->setParameter('dealer_group_id', $dealer_group_id);

        $res = $qb->getQuery()->getResult();

        return $res;
    }
}
