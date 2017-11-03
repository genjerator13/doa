<?php

namespace Numa\DOADMSBundle\Util;

use Doctrine\ORM\PersistentCollection;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Numa\DOADMSBundle\Entity\DealerGroup;
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

    /**
     * @return dealers id based whatever dealer or dealer principal is signed
     */
    public function getAvailableDealersIds()
    {
        $dealer = $this->getSignedUser();
        $dealer_id = "";
        if ($dealer instanceof Catalogrecords) {
            $dealer_id = $dealer->getId();
        } elseif ($dealer instanceof DealerGroup) {
            $dealer_id = $this->getDealerIdsFromPrincipal($dealer);
        } elseif ($dealer instanceof DMSUser) {
            $dealer_id = $dealer->getDealerId();
            $dealerGroup = $dealer->getDealerGroup();
            if($dealerGroup instanceof DealerGroup){
                $dealer_id = $this->getDealerIdsFromPrincipal($dealerGroup);
            }
        }
        return $dealer_id;
    }

    public function getSignedUser()
    {

        $token = $this->container->get('security.token_storage')->getToken();
        if (!empty($token)) {
            $dealer = $token->getUser();
            $session = $this->container->get('session');
            $dealerIdSession = $session->get('dms_dealer_id');
            if (!empty($dealerIdSession)) {
                $dealer = $this->em->getRepository('NumaDOAAdminBundle:Catalogrecords')->find($dealerIdSession);
            }
            return $dealer;
        }
        return null;
    }

    public function getDealerIdsFromPrincipal(DealerGroup $principal)
    {
        $dealer_id = array();
        if ($principal instanceof DealerGroup) {
            foreach ($principal->getDealer() as $dealer) {
                $dealer_id[] = $dealer->getId();
            }
        }

        return implode(",", $dealer_id);
    }

    public function getSignedDealerPrincipal()
    {
        $principal = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($principal instanceof DMSUser) {
            if($principal->getDealerGroup() instanceof DealerGroup){
                $principal = $principal->getDealerGroup();
            }
        }
        if ($principal instanceof DealerGroup) {
            return $principal;
        }


        return null;
    }

    public function getSignedDealerOrPrincipal()
    {
        $principal = $this->getSignedUser();

        if ($principal instanceof DealerGroup || $principal instanceof Catalogrecords) {
            return $principal;
        }

        return null;
    }

    public function getHost($request = null)
    {
        $dealer = $this->getSignedDealer();
        $url = empty($dealer) ? $request->getHost() : $dealer->getSiteUrl();

        return $url;
    }

    public function getSignedDealer()
    {
        $dealer = $this->getSignedUser();
        if ($dealer instanceof Catalogrecords) {
            return $dealer;
        }
        if ($dealer instanceof DMSUser) {
            return $dealer->getDealer();
        }
        if ($dealer instanceof DealerGroup) {
            if (empty($dealer->getDealerCreator()) && !empty($dealer->getDealer()) && $dealer->getDealer() instanceof PersistentCollection) {
                return $dealer->getDealer()->first();
            }
            return $dealer->getDealerCreator();
        }
        return null;
    }

    public function isAdmin()
    {
        $user = $this->getSignedUser();
        return in_array('ROLE_ADMIN', $user->getRoles());
    }

    public function isTruxrusDomain()
    {
        $host = $this->getCurrentSiteHost();
        return stripos($host, "truxrus") !== false;
    }

    public function getCurrentSiteHost()
    {
        $router = $this->container->get('router');
        $host = str_replace("www.", "", $router->getContext()->getHost());
        return $host;
    }

    public function getCurrentSiteHostWWW($host = null)
    {
        if (empty($host)) {
            $router = $this->container->get('router');
            $host = $router->getContext()->getHost();
        }

        if (stripos($host, "www") === false && stripos($host, "dealersonair.com") === false) {
            $host = "www." . $host;
        }
        return $host;
    }

    public function getScheme()
    {
        $router = $this->container->get('router');
        return $router->getContext()->getScheme();
    }

    public function getDealerGroupIdByHost()
    {

        $dealer = $this->getDealerByHost();
        if ($dealer instanceof Catalogrecords && $dealer->getDealerGroup() instanceof DealerGroup) {
            return $dealer->getDealerGroup()->getId();
        }
        return null;
    }

    public function getDealerByHost()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $host = $this->getCurrentSiteHost();
        $desDealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerByHost($host);
        return $desDealer;
        //check if www
        //$host = str_replace("www.", "", $host);

//        $serializer = $this->container->get('serializer');
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer(array($normalizer));


        $memDealer = $this->container->get('mymemcache')->get('dealer_' . $host);

        $dealer = null;
        if(empty($memDealer)){
            $dbObjDealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerByHost($host);
            $dealer = $dbObjDealer;
            $arrayDealer = $serializer->normalize($dbObjDealer, null, array('groups' => array('site')));
            $this->container->get('mymemcache')->set('dealer_' . $host,$arrayDealer);

        }else{

            $memObjDealer = $serializer->denormalize(
                $memDealer,
                Catalogrecords::class,
                null,
                array('groups' => array('site'))
            );
            $dealer = $memObjDealer;
            $memObjDealer->setId($memDealer['id']);

        }

        return $dealer;
    }

    public function isQBReady(Catalogrecords $dealer)
    {

        return $this->isLocalHost() || $this->isDevServer() || $dealer->getUsername() == "qbautodealer";
    }

    public function isLocalHost()
    {
        $host = $this->container->get("numa.dms.user")->getCurrentSiteHost();
        return (strpos($host, '.local') !== false);
    }

    public function isSaskatoonServer()
    {
        $path = $this->container->getParameter('web_path');
        return (strpos($path, 'saskatoondoa') !== false);
    }

    public function isDevServer()
    {
        $host = $this->container->get("numa.dms.user")->getCurrentSiteHost();
        return (strpos($host, 'dev.dealersonair') !== false);
    }

}