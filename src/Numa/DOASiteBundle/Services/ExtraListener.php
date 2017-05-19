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
    private $twig;
    public $page;

    public function __construct(ContainerInterface $container, $controller_resolver, $request_stack, $http_kernel)
    {
        $this->container = $container;
        $this->controller_resolver = $controller_resolver;
        $this->request_stack = $request_stack;
        $this->http_kernel = $http_kernel;
        $this->page = null;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

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
            //$host = trim(strip_tags($request->getHost()));
            //$dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);
            $dealer = $this->container->get("numa.dms.user")->getDealerByHost();

            $activeTheme = $this->container->get('liip_theme.active_theme');

            if ($dealer instanceof Catalogrecords) {
                $this->container->set('dealer', $dealer);

                $theme = $dealer->getSiteTheme();

                if (!(in_array($theme, $activeTheme->getThemes()))) {
                    $theme = $activeTheme->getThemes()[0];
                }

                $activeTheme->setName($theme);
                $controllerObject->initializeDealer($dealer);

            } else {
                $activeTheme->setName('Default');
            }

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
        $routeName = $request->get('_route');
        //ignore if route starts with dms

        if (!empty($routeName) && strpos(strtolower($routeName), "dms") !== 0 && strpos(strtolower($routeName), "api") === false) {
            $em = $this->container->get('doctrine.orm.entity_manager');
            $currentUrl = $request->getRequestUri();


            $dealer = $this->container->get("Numa.Dms.User")->getDealerByHost();
            //$session =$this->container->get("session");
            //$qbsession = $session->get("qb");
            //$qbset = isset($qbsession);
            //if(!isset($qbsession)){
            //    $qbo = $this->container->get("numa.quickbooks")->init();
            //dump($qbo);
            //}
            $page = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($currentUrl, $dealer);
            $html = $this->container->get('Numa.Settings')->replaceSeoInPageHTML($response->getContent(), $page, $dealer);

            $response->setContent($html);
        }
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof NotFoundHttpException) {

            $requestUri = $event->getRequest()->getRequestUri();

            $request = new \Symfony\Component\HttpFoundation\Request();

            if(substr($requestUri, 0, 5 ) === '/dms/'){
                $request->attributes->set('_controller', 'NumaDOASiteBundle:Default:error404DMS');
            }
            else{
                $request->attributes->set('_controller', 'NumaDOASiteBundle:Default:error404');
            }

            $controller = $this->controller_resolver->getController($request);

            $path['_controller'] = $controller;
            $subRequest = $this->request_stack->getCurrentRequest()->duplicate(array(), null, $path);

            $event->setResponse($this->http_kernel->handle($subRequest, HttpKernelInterface::MASTER_REQUEST)); // Simulating "forward" in order to preserve the "Not Found URL"

        }
    }

    public function preExecute(GetResponseForControllerResultEvent $event)
    {

        $request = $event->getRequest();
        $parameters = $event->getControllerResult();
        dump($parameters);
        die();
        if (!empty($parameters)) {
            $response = array();
            foreach ($parameters as $parameter => $value) {
                if (isset($this->_responseParameters[$parameter])) {
                    $response[$parameter] = $value;
                }
            }
            if (!empty($response)) {
                $request->attributes->set('_response', $response);
            }
        }
    }
}