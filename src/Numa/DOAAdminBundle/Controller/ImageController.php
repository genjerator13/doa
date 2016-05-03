<?php

namespace Numa\DOAAdminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOAAdminBundle\Form\ItemType;
use Symfony\Component\Yaml\Parser;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ArrayColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use Doctrine\Common\Collections\Criteria;

/**
 * Item controller.
 *
 */
class ImageController extends Controller
{

    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $ImageList = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Image List'));
        //\Doctrine\Common\Util\Debug::dump($ImageList->getId());
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("fieldName", "Image List"))
            ->orderBy(array('sortOrder' => Criteria::ASC));
        $images = $item->getItemField()->matching($criteria);
        ///

        foreach ($images as $image) {

            if (substr($image->getFieldStringValue(), 0, 4) !== "http") {
                $upload_path = $this->getParameter('web_path');

                $imageSource = $image->getFieldStringValue();

                //dump($upload_path);

                if (!file_exists($upload_path . $imageSource)) {
                    $imageSource = "/images/no_image_available_small.png";
                }


                $imagemanagerResponse = $this->container
                    ->get('liip_imagine.controller')
                    ->filterAction(
                        $this->getRequest(), $imageSource, 'item_detail_image'
                    );
                $imagemanagerResponse = $this->container
                    ->get('liip_imagine.controller')
                    ->filterAction(
                        $this->getRequest(), $imageSource, 'search_image'
                    );
            }
        }
        //}


        ///
        $order = 0;
        foreach ($images as $image) {
            $image->setSortOrder($order++);
            $em->persist($image);
        }
        $em->flush();
        if (!$item) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }


        return $this->render('NumaDOAAdminBundle:Item:images.html.twig', array(
            'item' => $item,
            'images' => $images,
            'addVideoForm' => $this->addVideoForm($id)->createView()
            //'addimages' => $uploadForm->createView(),
        ));
    }

    public function uploadAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        $file = $request->files->get('file');


        if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile &&
            ($file->getMimeType() == 'image/jpeg' ||
                $file->getMimeType() == 'image/png' ||
                $file->getMimeType() == 'image/gif')
        ) {
            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
            $ImageList = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Image List'));
            $upload_url = $this->container->getParameter('upload_url');
            $upload_path = $this->container->getParameter('upload_path');
            $itemField = new ItemField();

            $itemField->handleImage($file, $upload_path, $upload_url, $item->getImportFeed(), 0, true, $item->getId() . '_' . time());
            $item->setDateUpdated(new \DateTime());
            $itemField->setItem($item);
            $itemField->setListingfield($ImageList);
            $em->persist($itemField);
            $em->flush();
        }

        die();
    }

    public function addVideoForm($item_id)
    {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('item_images_add_video', array('id' => $item_id)))
            ->add('url', TextType::class, array('label' => 'Youtube video URL', 'attr' => array('class' => 'col-md-6')))
            ->add('send', SubmitType::class, array('label' => 'Add'))
            ->getForm();
        return $form;

    }

    public function addVideoAction(Request $request, $id)
    {

        $form = $this->addVideoForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
            $ImageList = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Image List'));

            $itemField = new ItemField();
            $itemField->setFieldBooleanValue(true);
            $itemField->setFieldStringValue($data['url']);

            $item->setDateUpdated(new \DateTime());
            $itemField->setItem($item);
            $itemField->setListingfield($ImageList);
            $em->persist($itemField);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('item_images', array('id' => $id)));
    }

    public function setImageOrderAction(Request $request)
    {
        $orders = $request->request->get('orders');
        $ordersArray = json_decode($orders, true);
        $em = $this->getDoctrine()->getManager();
        foreach ($ordersArray as $key => $order) {
            $id = (intval($key));
            $order = (intval($order));
            $qb = $em->getRepository("NumaDOAAdminBundle:ItemField")->createQueryBuilder('if')
                ->update()
                ->set('if.sort_order', $order)
                ->where('if.id=' . $id);
            $qb->getQuery()->execute();
        }
        die();
    }

}
