<?php

namespace Numa\DOADMSBundle\Util;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Numa\DOADMSBundle\Entity\DMSUser;
use Symfony\Component\DependencyInjection\Container;

class DmsUserLib
{
    /**
     * @var EntityManager
     */
    protected $em;
    protected $container;
    /**
     * @var EntityRepository
     */
    protected $repo;

    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->repo = null;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = null;
    }

    public function getSignedUser()
    {
        $dealer = $this->container->get('security.token_storage')->getToken()->getUser();
        $session = $this->container->get('session');
        $dealerIdSession = $session->get('dms_dealer_id');
        if (!empty($dealerIdSession)) {
            $dealer = $this->em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealerIdSession);
        }
        return $dealer;
    }
    public function getSignedDealer()
    {
        $dealer = $this->getSignedUser();

        if($dealer instanceof Catalogrecords ){
            return $dealer;
        }

        if($dealer instanceof DMSUser ){
            return $dealer->getDealer();
        }
        return null;
    }

    public function getHost($request)
    {
        $dealer = $this->getSignedDealer();
        $url = empty($dealer)? $request->getHost():$dealer->getSiteUrl();
        return $url;
    }

    public function isAdmin(){
        $user = $this->getSignedUser();
        return in_array('ROLE_ADMIN',$user->getRoles());
    }
    public function getCurrentSiteHost(){
        $router = $this->container->get('router');
        return $router->getContext()->getHost();
    }
    public function getDealerByHost(){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $host = $this->getCurrentSiteHost();
        //check if www
        $host = str_replace("www.","",$host);
        return $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerByHost($host);
    }
}