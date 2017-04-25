<?php

namespace Numa\DOASiteBundle\Controller;

use Numa\DOAAdminBundle\Form\SendEmailType;
use Numa\DOADMSBundle\Entity\ListingForm;
use Numa\DOADMSBundle\Form\ListingFormContactType;
use Numa\DOADMSBundle\Form\ListingFormDriveType;
use Numa\DOADMSBundle\Form\ListingFormEpriceType;
use Numa\DOADMSBundle\Form\ListingFormOfferTradeInType;
use Numa\DOADMSBundle\Form\ListingFormOfferType;
use Numa\DOADMSBundle\Form\ListingFormFinanceType;
use Numa\DOASiteBundle\Lib\DealerSiteControllerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller implements DealerSiteControllerInterface{

    public $dealer;
    public function initializeDealer($dealer){
        $this->dealer = $dealer;
    }

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
            throw $this->createNotFoundException('Listing not found!');
        }
        $seo = $em->getRepository('NumaDOAModuleBundle:Seo')->findSeoByItem($item);

        $url = $this->generateUrl('item_details',array('itemId'=>$item->getId(),'description'=>$item->getUrlDescription()),true);

        //get dealer
        $dealer = $item->getDealer();
        $dealerFromHost = $this->container->get("numa.dms.user")->getDealerByHost();

        if($dealer !== $dealerFromHost && isset($dealerFromHost)){
            throw $this->createNotFoundException('Listing not found!');
        }

        //increase views and insert log
        $em->getRepository('NumaDOAAdminBundle:Item')->addView($itemId);
        //insert log
        $em->getRepository('NumaDOAStatsBundle:Stats')->insertLog($item);

        $emailForm = $this->emailDealerForm($request, $dealer);

        if ($emailForm instanceof \Symfony\Component\Form\Form) {

            $response = $this->render('NumaDOASiteBundle:Item:detailsBoat.html.twig', array(
                'item' => $item,
                'seo'  => $seo,
                'url'  => $url,
                'dealer' => $dealer,
                'print' => $print,
                'searchQ' => $searchQ,
                'driveForm' => $this->createCreateDriveForm(new ListingForm())->createView(),
                'offerForm' => $this->createCreateOfferForm(new ListingForm())->createView(),
                'offerTradeInForm' => $this->createCreateOfferTradeInForm(new ListingForm())->createView(),
                'epriceForm' => $this->createCreateEpriceForm(new ListingForm())->createView(),
                'financeForm' => $this->createCreateFinanceForm(new ListingForm())->createView(),
                'contactForm' => $this->createCreateContactForm(new ListingForm())->createView(),
                'emailForm' => $emailForm->createView()));
            return $response;
        } else {
            return $emailForm;
        }
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateDriveForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormDriveType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'attr' => array('id'=>"testdrive_form")
        ));
        //$form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateOfferForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormOfferType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'attr' => array('id'=>"offer_form")

        ));

        return $form;
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateOfferTradeInForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormOfferTradeInType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'attr' => array('id'=>"offerTradeIn_form")
        ));
        // $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateEpriceForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormEpriceType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'allow_extra_fields'=>true,
            'attr' => array('id'=>"eprice_form")
        ));
       // $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateFinanceForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormFinanceType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'allow_extra_fields'=>true,
            'attr' => array('id'=>"finance_form")
        ));
        // $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }


    /**
     * Creates a form to create a ListingForm entity.
     *
     * @param ListingForm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateContactForm(ListingForm $entity)
    {
        $form = $this->createForm(new ListingFormContactType(), $entity, array(
            'action' => $this->generateUrl('listing_form_post'),
            'method' => 'POST',
            'attr' => array('id'=>"contact_form")
        ));
        // $form->add('submit', 'submit', array('label' => 'Create'));
        return $form;
    }

    public function saveadAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $itemid = intval($request->request->get('itemid'));
        $em = $this->get('doctrine')->getManager();
        //$em->getRepository("NumaDOAAdminBundle:Catalogrecords")->

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
        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();

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
        return $this->render('NumaDOASiteBundle:Item:comparedListings.html.twig', array(
            'fields' => $tempIncludedFields,
            'items' => $temp,
            'optionsNames'=> $optionsNames,
            'options'=> $options,
            'dealer'=>$dealer,
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

    public function epriceAction($itemid){
        $listingForm = new ListingForm();
        $listingForm->setItemId(intval($itemid));
        $epriceForm = $this->createCreateEpriceForm($listingForm);
        $epriceForm->add("item_id","hidden");
        return $this->render('NumaDOASiteBundle:Item:eprice.html.twig', array('item_id'=>$itemid,'epriceForm' => $epriceForm->createView() ));
    }

    public function financeAction($itemid){
        $listingForm = new ListingForm();
        $listingForm->setItemId(intval($itemid));
        $financeForm = $this->createCreateFinanceForm($listingForm);
        $financeForm->add("item_id","hidden");
        return $this->render('NumaDOASiteBundle:Item:finance.html.twig', array('item_id'=>$itemid,'financeForm' => $financeForm->createView() ));
    }

    public function manageAction()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('NumaDOADMSBundle:Inventory:index.html.twig', array(
            'dealer'=>$this->get("numa.dms.user")->getSignedDealer()
        ));
    }

}
