<?php

namespace Numa\DOAAdminBundle\Controller;

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
class ImageController extends Controller {

    public function showAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository('NumaDOAAdminBundle:Item')->find($id);
        $ImageList = $em->getRepository('NumaDOAAdminBundle:Listingfield')->findOneBy(array('caption' => 'Image List'));
        //\Doctrine\Common\Util\Debug::dump($ImageList->getId());
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq("fieldName", "Image List"))
                ->orderBy(array('sortOrder' => Criteria::ASC))
        ;
        $images = $item->getItemField()->matching($criteria);
        ///

        foreach ($images as $image) {

            $imagemanagerResponse = $this->container
                    ->get('liip_imagine.controller')
                    ->filterAction(
                    $this->getRequest(), $image->getFieldStringValue(), 'item_detail_image'
            );
            $imagemanagerResponse = $this->container
                    ->get('liip_imagine.controller')
                    ->filterAction(
                    $this->getRequest(), $image->getFieldStringValue(), 'search_image'
            );
        }


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

        $uploadForm = $this->createAddImagesForm($item->getId());
        $uploadForm->handleRequest($request);


        if ($uploadForm->isValid()) {
            // If form is valid
            // Get file
            $files = $request->files->get('form');

            foreach ($files as $file) {

                if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile &&
                        ($file->getMimeType() == 'image/jpeg' ||
                        $file->getMimeType() == 'image/png' ||
                        $file->getMimeType() == 'image/gif')) {

                    $upload_url = $this->container->getParameter('upload_url');
                    $upload_path = $this->container->getParameter('upload_path');
                    $itemField = new ItemField();
                    $itemField->handleImage($file, $upload_path, $upload_url, $item->getImportFeed(), 0, false);

                    $itemField->setItem($item);
                    $itemField->setListingfield($ImageList);
                    $em->persist($itemField);
                }
                $em->flush();
            }
            return $this->redirect($this->generateUrl('item_images', array('id' => $id)));
        }


        return $this->render('NumaDOAAdminBundle:Item:images.html.twig', array(
                    'item' => $item,
                    'images' => $images,
                    'addimages' => $uploadForm->createView(),
        ));
    }

    public function createAddImagesForm($item_id) {
        $data = array();
        return $this->createFormBuilder($data)
                        //->setAction($this->generateUrl('images_add', array('item_id' => $item_id)))
                        ->add('Picture1', 'file', array('label' => 'Picture 1', 'required' => false))
                        ->add('Picture2', 'file', array('label' => 'Picture 2', 'required' => false))
                        ->add('Picture3', 'file', array('label' => 'Picture 3', 'required' => false))
                        ->add('Picture4', 'file', array('label' => 'Picture 4', 'required' => false))
                        ->add('Picture5', 'file', array('label' => 'Picture 5', 'required' => false))
                        ->add('Upload', 'submit', array('label' => 'Upload'))
                        ->getForm();
    }

    public function orderPlus() {
        
    }

}
