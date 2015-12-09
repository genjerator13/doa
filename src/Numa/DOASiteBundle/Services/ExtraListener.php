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
        $kernel    = $event->getKernel();
        $request   = $event->getRequest();
        $container = $this->container;
        //$controller = $event->getController();
        //$request->set
        $routeName = $request->get('route');
        //$container->set("seo")="TESTTEST";
        //dump($routeName);
        //dump($event);
        //die();
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
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