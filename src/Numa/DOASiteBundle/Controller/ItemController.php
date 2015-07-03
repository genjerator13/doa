<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller {

    public function detailsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $itemId = $request->get('itemId');
        $searchQ = $request->query->get('searchQ');

        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        $print = false;
        if ($routeName == 'item_print_details') {
            $print = true;
        }

        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemId);
        //$test = $em->getRepository('NumaDOAAdminBundle:ListingFieldTree')->getJsonTree();
        //
        if (empty($item)) {
            throw $this->createNotFoundException('message');
        }
        //$itemfields = $item->getItemFieldsArray();
        //get dealer
        $dealerid = $item->getItemFieldByName('dealer');

        $dealer = "";
        if (!empty($dealerid)) {
            $dealer = $em->getRepository('NumaDOAAdminBundle:CatalogRecords')->find($dealerid);
        }
        //\Doctrine\Common\Util\Debug::dump($item->getItemFieldsArray());
        //add 1 more view
        $item->setViews($item->getViews() + 1);
        $em->flush();
        $emailForm = $this->emailDealerForm($request,$item->getDealer());
        
        if($emailForm instanceof \Symfony\Component\Form\Form ){
            return $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array('item' => $item,
                        'dealer' => $dealer,
                        'print' => $print,
                        'searchQ' => $searchQ,
                        'emailForm' => $emailForm->createView()));
        }else{
            return $emailForm;
        }
    }

    public function saveadAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $itemid = intval($request->request->get('itemid'));
        
        
        $act = $request->get('act');
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemid);
        $ret = array();
            
        if ($item instanceof \Numa\DOAAdminBundle\Entity\Item || $user instanceof Numa\DOAAdminBundle\Entity\User) {

            $userItem = $em->getRepository('NumaDOAAdminBundle:UserItem')
                    ->findOneBy(array('User' => $user,
                'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
            $userItems = $em->getRepository('NumaDOAAdminBundle:UserItem')
                    ->findBy(array('User' => $user,
                'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
            $userItemsCount = count($userItems);

            if ($act == 'add') {
                $userItemExists = $em->getRepository('NumaDOAAdminBundle:UserItem')
                        ->findOneBy(array('User' => $user,
                    'Item' => $item,
                    'item_type' => \Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD));
                
                if (empty($userItemExists)) {
                    $userItem = new \Numa\DOAAdminBundle\Entity\UserItem();
                    $userItem->setUser($user);
                    $userItem->setItem($item);
                    $userItem->setItemType(\Numa\DOAAdminBundle\Entity\UserItem::SAVED_AD);
                    $em->persist($userItem);
                    $userItemsCount++;
                }
            } elseif ($act == 'remove') {
                $userItemsCount--;
                $em->remove($userItem);
            }

            $em->flush();
            $savedAds = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemid);
            $ret = array('savedAds' => $userItemsCount);
        }
        $response = new Response(json_encode($ret));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function compareAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $itemid = intval($request->get('itemid'));
        $act = $request->get('act');
        $item = $em->getRepository('NumaDOAAdminBundle:Item')->findOneById($itemid);
        $ret = array();
        $session = $this->getRequest()->getSession();
        $comparedItems = $session->get('comparedItem');
        if ($act == 'removeall') {
            $session->remove('comparedItem');
        }

        if ($item instanceof \Numa\DOAAdminBundle\Entity\Item) {

            if (empty($comparedItems)) {
                $comparedItems = array();
            }
            if ($act == 'add') {
                $comparedItems[$itemid] = $itemid;
            } elseif ($act == 'remove') {

                unset($comparedItems[$itemid]);
            }
            $session->set('comparedItem', $comparedItems);
        }

        if ($request->isXmlHttpRequest()) {
            $ret = array('comparedItes' => count($comparedItems));
            $response = new Response(json_encode($ret));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return $this->redirect($this->generateUrl('compared_listings'));
    }

    public function comparedListingAction(Request $request) {
        $session = $this->getRequest()->getSession();
        $comparedItems = $session->get('comparedItem');
        $em = $this->getDoctrine()->getManager();
        $fields = array(
            array('name' => 'id'),
            array('name' => 'image', 'type' => 'image'),
            array('name' => 'activation_date', 'type' => 'date', 'format' => 'yyyy mm dd'),
            array('name' => 'year'),
            array('name' => 'fuel_type'),
            array('name' => 'status'),
            array('name' => 'address'),
            array('name' => 'province'),
            array('name' => 'is_sold'),
            array('name' => 'vin'),
            array('name' => 'city'),
            array('name' => 'postal code'),
            array('name' => 'price', 'type' => 'price'),
            array('name' => 'boat make'), //
        );
        $comparedItemsArray = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('id' => $comparedItems));

        return $this->render('NumaDOASiteBundle:Item:comparedListings.html.twig', array('fields' => $fields, 'items' => $comparedItemsArray));
    }

    public function qrcodeAction(Request $request) {
        $link = $request->get('link');
        return $this->redirect($this->generateUrl('endroid_qrcode', array(
                            'text' => $link,
                            'extension' => 'png',
                            'size' => 500
        )));
    }

    public function emailDealerForm($request,$dealer) {
        $data = array();
        $form = $this->createFormBuilder($data)
                ->add('comments', 'textarea')
                ->add('first_name', 'text')
                ->add('last_name', 'text')
                ->add('email', 'email')
                ->add('dealer', 'hidden')
                ->getForm();

        if ($request->isMethod('POST') && $dealer instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords && $dealer->getEmail()) {
            $form->bind($request);

            // $data is a simply array with your form fields 
            // like "query" and "category" as defined above.
            $data = $form->getData();
            $emailFrom = $data['email'];
            $emailTo = $dealer->getEmail();
            $emailBody = $data['comments'];
            $twig = $this->container->get('twig');
            $globals = $twig->getGlobals();
            $subject = $globals['subject'];
            $title = $globals['title'];
            $subject = $subject ." ".$title;

            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
                    ->setSubject('email from ')
                    ->setFrom($emailFrom)
                    ->setTo('e.medjesi@gmail.com')
                    ->setBody($emailTo.":".$emailBody);

            $ok = $mailer->send($message);
            $currentRoute = $request->attributes->get('_route');
            $currentRouteParams = $request->attributes->get('_route_params');
            
            $currentUrl = $this->get('router')
                     ->generate($currentRoute, $currentRouteParams, true);

            return $this->redirect($currentUrl);
        }
        return $form;
    }
}
