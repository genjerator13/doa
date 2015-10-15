<?php

namespace Numa\DOAAdminBundle\Listeners;

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
 
class AccessListener implements AuthenticationSuccessHandlerInterface
{
    
    protected $router;
    protected $tokenStorage;
    protected $checker;

    public function __construct(Router $router, TokenStorage $tokenStorage, AuthorizationChecker $checker)
    {
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
        $this->checker = $checker;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //$user = $this->tokenStorage->getToken()->getUser();
        if ($this->checker->isGranted('ROLE_SUPER_ADMIN'))
        {
            $response = new RedirectResponse($this->router->generate('numa_doa_admin_homepage'));            
        }
        elseif ($this->checker->isGranted('ROLE_ADMIN'))
        {
            $response = new RedirectResponse($this->router->generate('numa_doa_admin_homepage'));
        }
        elseif ($this->checker->isGranted('ROLE_USER'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('homepage'));
        }elseif ($this->checker->isGranted('ROLE_BUSINES'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('homepage'));
        }elseif ($this->checker->isGranted('ROLE_DEALER_ADMIN'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('homepage'));
        }
        $response = new RedirectResponse($this->router->generate('homepage'));
        return $response;
    }
    
}
