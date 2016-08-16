<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3.12.15.
 * Time: 13.06
 */

namespace Numa\DOASiteBundle\Services;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Lib\DashboardDMSControllerInterface;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExtraListener
{
    protected $container;
    private $controller_resolver;
    private $request_stack;
    private $http_kernel;

    public function __construct(ContainerInterface $container,$controller_resolver, $request_stack, $http_kernel)
    {
        $this->container = $container;
        $this->controller_resolver = $controller_resolver;
        $this->request_stack = $request_stack;
        $this->http_kernel = $http_kernel;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {

    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }

        $controllerObject = $controller[0];

        // skip initializing for exceptions
        if ($controllerObject instanceof ExceptionController) {
            return;
        }

        if ($controllerObject instanceof DealerSiteControllerInterface) {
            // this method is the one that is part of the interface.


            $setting = $this->container->get("Numa.settings");

            //$host = $setting->get('host');
            $request = $event->getRequest();
            //$session = $request->getSession();
            $em = $this->container->get('doctrine.orm.entity_manager');
            $host = trim(strip_tags($request->getHost()));
            $dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);

            $activeTheme = $this->container->get('liip_theme.active_theme');

            if ($dealer instanceof Catalogrecords) {
                $this->container->set('dealer', $dealer);

                $theme = $dealer->getSiteTheme();

                $activeTheme->setName($theme);
                $controllerObject->initializeDealer($dealer);

            }else{

                $activeTheme->setName('Default');

            }

//            $request = $event->getRequest();
//            $pathinfo = $request->getPathInfo();
//
//            if (substr($pathinfo, 0, 2) === "/d") {
//                $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
//            }

            //$em = $this->container->get('doctrine.orm.entity_manager');
            //$dealer_id = null;
            //$pcomponents = array();
            //$dcomponents = array();
            //if ($dealer instanceof Catalogrecords) {
            //    $pcomponents = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId());
            //    $dcomponents = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->findDealerComponents($dealer->getId());
            //}
            //$components['page'] = $pcomponents;
            //$components['dealer'] = $dcomponents;
            //$controllerObject->initializePageComponents($pcomponents);
            //$controllerObject->initializeDealerComponents($dcomponents);
            //}

        }
        if ($controllerObject instanceof DashboardDMSControllerInterface) {
            $request = $event->getRequest();
            $route = $request->get('_route');
            $dashboard = "";
            if (strtolower(substr($route, 0, 3)) === "dms") {
                $dashboard = "DMS";

            }

            $controllerObject->initializeDashboard($dashboard);
        }
    }


    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();
        $kernel = $event->getKernel();
        $container = $this->container;
        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        $em = $this->container->get('doctrine.orm.entity_manager');

        $currentUrl = $request->getRequestUri();
        //dump($currentUrl);die();
        $page = $em->getRepository('NumaDOAModuleBundle:Page')->findOneBy(array('url' => $currentUrl));
        if ($page instanceof Page) {
            $pageDescription = $page->getDescription();
            $pageTitle = $page->getTitle();

            $html = $response->getContent();
            //dump($request);
            //dump($routeParams);
            //die();

            //$html = preg_replace('/<meta.*?name=("|\')description("|\').*?content=("|\')(.*?)("|\')/i',"aaaa", $html);
            $html = preg_replace('/<meta name=\"description\" content=\"(.*)\" \/>/i', '<meta name="description" content="' . $pageDescription . '" />', $html);
            $html = preg_replace('/<meta name=\"keywords\" content=\"(.*)\" \/>/i', '<meta name="keywords" content="' . $pageTitle . '" />', $html);
            $html = preg_replace('/<title>(.*)<\/title>/i', "<title>" . $pageDescription . "</title>\n", $html);

            $response->setContent($html);
        }
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        if ($event->getException() instanceof NotFoundHttpException) {

            $request = new \Symfony\Component\HttpFoundation\Request();
            $request->attributes->set('_controller', 'NumaDOASiteBundle:Default:error404');
            $controller = $this->controller_resolver->getController($request);

            $path['_controller'] = $controller;
            $subRequest = $this->request_stack->getCurrentRequest()->duplicate(array(), null, $path);

            $event->setResponse($this->http_kernel->handle($subRequest, HttpKernelInterface::MASTER_REQUEST)); // Simulating "forward" in order to preserve the "Not Found URL"

        }
    }
}