<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Imagine\Image\Box;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;

class ImageLib
{
    protected $container;
    protected $delete = array();
    protected $nodelete = array();

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function getAbsoluteImagePathFromItem(Item $item)
    {
        $photo = $this->getAbsoluteImagePath($item->getPhoto());
        return $photo;
    }

    public function getAbsoluteCoverImagePathFromItem(Item $item)
    {
        $dealer = $item->getDealer();
        $site="";
        if($dealer instanceof Catalogrecords){
            $site = 'http://'.$dealer->getSiteUrl();
        }
        //$photo = $this->getAbsoluteImagePath($item->getCoverPhoto());
        return $site.$item->getCoverPhoto();
    }




    public function getAbsoluteImagePath($filename)
    {
        $path = "";

        if (!empty($filename)) {
            if ($this->isLocalImage($filename)) {
                $webpath = $this->container->getParameter('web_path');
                //$webpath = str_replace("/../", "/", $webpath);
                $webpath = str_replace("//", "/", $webpath);
                $path = $webpath . $filename;

                if (!file_exists($path)) {
                    $path = "";
                }
            } else {
                $path = $filename;
            }
        }
        return $path;
    }

    public function isLocalImage($filename)
    {
        $http = substr($filename, 0, 4) == 'http';
        if ($http) {
            return false;
        }
        return true;
    }

    public function fitIntoHeight($photo, $h)
    {
        $size = getimagesize($photo);
        $height = $size[1];
        $width = $size[0];
        $res = array();
        $res['height'] = intval($h);
        $res['width'] = intval(($width * $h) / $height);

        return $res;
    }


    public function deleteImagesNotInDB($path)
    {
        $images = $this->getAllImagesIntoArray();
        $dir = 'upload/itemsimages'; // path from top
        $scanedFiles = scandir($dir);
        $files = array_diff($scanedFiles, array('.', '..'));
        $delete = array();
        $noDelete = array();

        foreach ($files as $file) {
            // "is_dir" only works from top directory, so append the $dir before the file
            if (is_dir($dir . '/' . $file)) {
                $scanedFilesFolder = scandir($dir . '/' . $file);
                $filesFolder = array_diff($scanedFilesFolder, array('.', '..'));
                foreach ($filesFolder as $fileFolder) {
                    $img = $dir . '/' . $file . '/' . $fileFolder;
                    //dump('/'.$img);
                    if (!in_array('/' . $img, $images)) {
                        //$this->deleteImage($img);
                        $delete[] = $path . "/" . $img;
                        //dump("not EXISTS");
                    } else {
                        $noDelete[] = $img;
//                        dump("EXISTS");
//                        dump($img);
                    }
                }

            } else {
                $img = $dir . '/' . $file;
                //dump('/'.$img);
                if (!in_array('/' . $img, $images)) {
                    //$this->deleteImage($img);
                    $delete[] = $path . "/" . $img;
                } else {
                    //dump("EXISTS");
                    $noDelete[] = $img;
                }
            }
        }
        dump("DELETE");
        dump($delete);
        foreach ($delete as $item) {
            $this->deleteImage($item);
        }
        //dump("no DELETE");
        //dump($noDelete);
        die();

    }

    public function getAllImagesIntoArray()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $images = $em->getRepository('NumaDOAAdminBundle:ItemField')->getLocalImages();
        $arrayImages = array();
        foreach ($images as $image) {

            $arrayImages[] = str_replace("//", "/", $image->getFieldStringValue());
        }
        return $arrayImages;
    }

    public function deleteImage($filename)
    {
        if (file_exists($filename)) {
            unlink($filename);
            dump($filename);
        }
    }

    public function shrinkCoverImage($filename, $filter)
    {
        if (!empty($filename)) {
            $cachedImageUrl = "/media/cache/" . $filter;
            $cachedPath = $this->container->get('kernel')->getRootDir() . "/../web" . $cachedImageUrl;
            $origPath = $upload_path = $this->container->getParameter('web_path');

            $image = $filename;
            $cachedImage = $this->cleanUrl($cachedPath . $image);
            $cachedImageUrl = $cachedImageUrl . $image;
            $origImage = $this->cleanUrl($origPath . $image);

            if (file_exists($origImage) && !file_exists($cachedImage)) {

                $processedImage = $this->container->get('liip_imagine.data.manager')->find('inventory_cover', $image);


                $newimage = $this->container->get('liip_imagine.filter.manager')->applyFilter($processedImage, 'inventory_cover');
                $newimage_string = $newimage->getContent();
                $this->container->get('liip_imagine.cache.manager')->store($newimage, $filename, $filter);
                $image = $this->container->get('liip_imagine.cache.manager')->getBrowserPath($filename, $filter);

                return $image;

            }

            if (file_exists($cachedImage)) {
                return $cachedImageUrl;
            }
        }
        return $filename;
    }

    public function cleanUrl($url)
    {
        $result = str_replace('app/../', '', $url);
        $result = str_replace('//', '/', $result);
        return $result;
    }

    public function downsizeImage($path, $filter)
    {
        $container = $this->container; // the DI container, if keeping this function in controller just use $container = $this
        $imagine = $container->get('liip_imagine');
        $filterManager = $container->get('liip_imagine.filter.manager');

        $image = $imagine->open($path);
        if ($image instanceof \Imagine\Gd\Image) {
        }
        $width = $image->getSize()->getWidth();
        $height = $image->getSize()->getHeight();
        $ratio = $height / $width;
        if ($image->getSize()->getWidth() > 1920) {
            $image->resize(new Box(1920, 1920 * $ratio))->save($path);
        }
    }

    public function clearCacheDealer($dealerId){
        $dealer = $dealerId;
        $em = $this->container->get("doctrine")->getManager();
        if(!$dealerId instanceof Catalogrecords){

            $dealer = $em->getRepository(Catalogrecords::class)->find($dealerId);
        }
        $items =  $em->getRepository(Item::class)->findAllByDealer($dealer);
        $total = 0;
        foreach($items as $item){
            $t = $this->clearCacheImagesItem($item);
            $total = $total+$t;
        }

        return $total;

    }

    public function clearCacheImagesItemId($itemId){

        $em = $this->container->get("doctrine")->getManager();
        $item=$em->getRepository(Item::class)->find($itemId);
        return $this->clearCacheImagesItem($item);
    }

    public function clearCacheImagesItem(Item $item){

        $images = $item->getImagesForApi();
        $dealer=$item->getDealer();
        $url = $dealer->getSiteUrl();
        $path = $this->container->getParameter('kernel.root_dir')."/../web";

        $liipCacheManager = $this->container->get("liip_imagine.cache.manager");

        if(!empty($images['image'])) {
            foreach ($images['image'] as $image) {

                $test = $liipCacheManager->remove($image);
            }
            return count($images['image']);
        }
        return 0;
    }
}