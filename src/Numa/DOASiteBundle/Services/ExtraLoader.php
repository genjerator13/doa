<?php

namespace Numa\DOASiteBundle\Services;
//namespace Acme\RoutingBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ExtraLoader implements LoaderInterface
{
    private $loaded = false;
    protected $container;

    public function __construct(ContainerInterface $container = null,TokenStorage $token)
    {
        $this->container = $container;
    }
    public function load($resource, $type = null)
    {

        $routes = new RouteCollection();
        $pattern = '/bbb';
        $defaults = array(
            '_controller' => 'NumaDOASiteBundle:Default:Index',
        );

        $route = new Route($pattern, $defaults);
        $routes->add('extraRoute', $route);

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }

    public function getResolver()
    {
    }

    public function setResolver(LoaderResolverInterface $resolver)
    {
        // TODO: Implement setResolver() method.
    }
}
