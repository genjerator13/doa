<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Form\SendEmailType;
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


        if (empty($item)) {
            throw $this->createNotFoundException('message');
        }
        $url = $this->generateUrl('item_details',array('itemId'=>$item->getId(),'description'=>strtolower($item->getMake()."-".$item->getModel())),true);
        //get dealer
        $dealer = $item->getDealer();


        $item->setViews($item->getViews() + 1);
        $item->setDontUpdate();
        $em->flush();
        $emailForm = $this->emailDealerForm($request, $item->getDealer());

        if ($emailForm instanceof \Symfony\Component\Form\Form) {

            $response = $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array(
                'item' => $item,
                'url'  => $url,
                'dealer' => $dealer,
                'print' => $print,
                'searchQ' => $searchQ,
                'emailForm' => $emailForm->createView()));
            return $response;
        } else {
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

        $listingFields = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findAllOrderedBy('order');

       
        $comparedItemsArray = $em->getRepository('NumaDOAAdminBundle:Item')->findBy(array('id' => $comparedItems));

        $temp = array();
        $includedFields = array();
        $tempIncludedFields = array();
        $options = array();
        $optionsNames = array();

        foreach($comparedItemsArray as $item){

            foreach($listingFields as $field){
                $t=array();
                $t['name'] = $field->getCaption();
                $t['type'] = $field->getType();
                $t['value'] = $item->get($field->getCaption());

                if($field->getType()=='date'){
                    $t['format']='yyyy mm dd';
                }elseif($field->getType()=='array'){
                    $values = $item->get($field->getCaption());
                    if(!empty($values->first())) {
                        $t['type']  = 'image';
                        $t['value'] = $values->first();
                    }
                }
                $itemOptions = $item->getOptions();

                if(!empty($itemOptions)) {

                    foreach ($itemOptions as $option) {
                        $optName = strtolower(str_replace(array(" ",")","("),"_",$option->getFieldName()));
                        $tmpOption['name']=$option->getFieldName();
                        $tmpOption['value']=true;
                        $optionsNames[$optName]=$option->getFieldName();
                        $options[$item->getId()][$optName] = $tmpOption;
                    }
                }

                if(stripos(strtolower($field->getCaption()),'dealer')!==false){
                    $t['type'] = 'dealer';
                    $t['value'] = $item->getDealer()->getName();
                }

                if(!empty($t['value'])) {

                    $temp[$item->getId()]['list'][$field->getId()] = $t;
                    $temp[$item->getId()]['item'] = $item;
                }
                $includedFields[$field->getId()]=false;
                $includedFields[$field->getId()]=$includedFields[$field->getId()] || !empty($t['value']);
                if($includedFields[$field->getId()]==true){

                    $tempIncludedFields[$field->getId()]['id']=$field->getId();
                    $tempIncludedFields[$field->getId()]['name']=$field->getCaption();
                }
            }


        }
//        dump($optionsNames);
        //dump($options);die();
        return $this->render('NumaDOASiteBundle:Item:comparedListings.html.twig', array('fields' => $tempIncludedFields,
                                                                                        'items' => $temp,
                                                                                        'optionsNames'=> $optionsNames,
                                                                                        'options'=> $options,
                                                                                        ));
    }

    public function qrcodeAction(Request $request) {
        $link = $request->get('link');
        return $this->redirect($this->generateUrl('endroid_qrcode', array(
                            'text' => $link,
                            'extension' => 'png',
                            'size' => 500
        )));
    }

    public function emailDealerForm($request, $dealer) {
        $data = array();
        $form = $this->createFormBuilder($data)
                ->add('comments', 'textarea')
                ->add('first_name', 'text')
                ->add('last_name', 'text')
                ->add('email', 'email')
                ->add('dealer', 'hidden')
                ->add('captcha', 'genemu_captcha',array('mapped' => false,))
                //->addEventListener(FormEvents::PRE_BIND, array($listener, 'ensureCaptchaField'), -10)
                ->getForm();
        $form = $this->createForm(new SendEmailType($this->container), $data);

        $form->handleRequest($request);
        if ($form->isValid() && $request->isMethod('POST') && $dealer instanceof \Numa\DOAAdminBundle\Entity\Catalogrecords && $dealer->getEmail()) {
            $data= $form->getData();
//            dump($form);
//            dump($request);die();
            $mymailer = $this->get('Numa.Emailer');
            $messageParam = $mymailer->sendEmail($request,$data, $dealer);
            if(empty($messageParam['errors'])){
                $this->addFlash('success', "Email has been sent!");
            }

            return $this->redirect($messageParam['redirectto']);
        }else{

            if(!empty($form->getErrors()->count())) {
                $this->addFlash('danger', "Captcha code invalid, please try again to send email.");
            }

        }
        return $form;
    }

}
