<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3.12.15.
 * Time: 13.06
 */

namespace Numa\DOASiteBundle\Services;


use Numa\DOAModuleBundle\Entity\Page;
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
        $request = $event->getRequest();
        $session = $request->getSession();
        $params = $request->get('_route_params');
        $dashboard="";
        //$session->clear();//'dealer_id')

        if(empty($session->get('dealer_id'))){
            //get from host from settings
            $setting = $this->container->get("Numa.settings");
            $host = $setting->get('host');

//            dump($host);
//            dump(strip_tags($request->getHost()));
            if(trim(strip_tags($host))==trim(strip_tags($request->getHost()))){
                $dealer = $setting->getDealerForHost(trim($host));
//                dump($dealer);
                $this->container->set('dealer',$dealer);
                $session->set('dealer_id',$dealer->getId());
            }


        }

//        die($session->get('dealer_id'));

//        $this->container->set('dashboard_route_prefix',"");
//        $session->set('dashboard_route_prefix',"");
//        if (strpos($request->getPathInfo(), '/dms') !== false) {
//
//            $dashboard='DMS';
//            if (empty($session->get('dashboard'))) {
//
//                $this->container->set('dashboard', $dashboard);
//                $session->set('dashboard', $dashboard);
//            }
//
//            if (empty($session->get('dashboard_route_prefix'))) {
//                $drp = strtolower($dashboard) . "_";
//                $this->container->set('dashboard_route_prefix', $drp);
//                $session->set('dashboard_route_prefix', $drp);
//                $this->container->set('is_dms', strtolower($dashboard) == 'dms');
//                $session->set('is_dms', strtolower($dashboard) == 'dms');
//            }
//        }
        //dump($session->get('dashboard_route_prefix'));die();


    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        //$controller->set
        //dump($controller);die();
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response  = $event->getResponse();
        $request   = $event->getRequest();
        $kernel    = $event->getKernel();
        $container = $this->container;
        $routeName = $request->get('_route');
        $routeParams = $request->get('_route_params');
        $em = $this->container->get('doctrine.orm.entity_manager');

        $currentUrl = $request->getRequestUri();
        //dump($currentUrl);die();
        $page = $em->getRepository('NumaDOAModuleBundle:Page')->findOneBy(array('url'=>$currentUrl));
        if($page instanceof Page) {
            $pageDescription = $page->getDescription();
            $pageTitle = $page->getTitle();

            $html = $response->getContent();
            //dump($request);
            //dump($routeParams);
            //die();

            //$html = preg_replace('/<meta.*?name=("|\')description("|\').*?content=("|\')(.*?)("|\')/i',"aaaa", $html);
            $html = preg_replace('/<meta name=\"description\" content=\"(.*)\" \/>/i','<meta name="description" content="'.$pageDescription.'" />', $html);
            $html = preg_replace('/<meta name=\"keywords\" content=\"(.*)\" \/>/i','<meta name="keywords" content="'.$pageTitle.'" />', $html);
            $html = preg_replace('/<title>(.*)<\/title>/i',"<title>".$pageDescription."</title>\n", $html);

            $response->setContent($html);
        }
    }
}