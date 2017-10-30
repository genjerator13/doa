<?php

namespace Numa\DOAAdminBundle\Listeners;

use Doctrine\Tests\ORM\Mapping\Cat;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutListener implements LogoutSuccessHandlerInterface
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }



    public function onLogoutSuccess(Request $request)
    {
        $dealer = $this->container->get("numa.dms.user")->getSignedDealer();

        if($dealer instanceof Catalogrecords){
            return new RedirectResponse($dealer->getAbsoluteSiteUrl());
        }

        return new RedirectResponse("/");


    }

}
