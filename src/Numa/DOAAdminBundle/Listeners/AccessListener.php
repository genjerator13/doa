<?php

namespace Numa\DOAAdminBundle\Listeners;

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
    protected $security;
    
    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        
        if ($this->security->isGranted('ROLE_SUPER_ADMIN'))
        {
            $response = new RedirectResponse($this->router->generate('numa_doa_admin_homepage'));            
        }
        elseif ($this->security->isGranted('ROLE_ADMIN'))
        {
            $response = new RedirectResponse($this->router->generate('numa_doa_admin_homepage'));
        }
        elseif ($this->security->isGranted('ROLE_USER'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('homepage'));
        }elseif ($this->security->isGranted('ROLE_BUSINES'))
        {
            // redirect the user to where they were before the login process begun.
            $response = new RedirectResponse($this->router->generate('homepage'));
        }
            
        return $response;
    }
    
}
