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

class ExtraListener
{
    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
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

            //if(trim(strip_tags($host))==trim(strip_tags($request->getHost()))){
            //$dealer = $setting->getDealerForHost(trim($host));

            if ($dealer instanceof Catalogrecords) {
                $this->container->set('dealer', $dealer);
                //$session->set('dealer_id', $dealer->getId());
                //$setting->activateTheme($host);
                $theme = $dealer->getSiteTheme();
                $activeTheme = $this->container->get('liip_theme.active_theme');
                $activeTheme->setName($theme);
                $controllerObject->initializeDealer($dealer);
            }else{
                $activeTheme = $this->container->get('liip_theme.active_theme');
                $activeTheme->setName('Default');
            }

            $request = $event->getRequest();
            $pathinfo = $request->getPathInfo();

            if (substr($pathinfo, 0, 2) === "/d") {
                $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
            }

            $em = $this->container->get('doctrine.orm.entity_manager');
            $dealer_id = null;
            $components = null;
            if ($dealer instanceof Catalogrecords) {
                $components = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId());
            }

            $controllerObject->initializePageComponents($components);
            //}

        } elseif ($controllerObject instanceof DashboardDMSControllerInterface) {
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
}