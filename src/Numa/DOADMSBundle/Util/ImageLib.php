<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Item;

class ImageLib
{
    protected $container;

    /**
     * ListingFormHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct($container) // this is @service_container
    {
        $this->container = $container;
    }

    public function getAbsoluteImagePath($filename){
        $path = "";

        if(!empty($filename)) {
            if($this->isLocalImage($filename)) {
                $webpath = $this->container->getParameter('web_path');
                //$webpath = str_replace("/../", "/", $webpath);
                $webpath = str_replace("//", "/", $webpath);
                $path = $webpath . $filename;

                if (!file_exists($path)) {
                    $path = "";
                }
            }else{
                $path = $filename;
            }
        }
        return $path;
    }

    public function getAbsoluteImagePathFromItem(Item $item){
        $photo = $this->getAbsoluteImagePath($item->getPhoto());
        return $photo;
    }

    public function isLocalImage($filename){
        $http = substr($filename, 0, 4) == 'http';
        if ($http) {
            return false;
        }
        return true;
    }

    public function fitIntoHeight($photo,$h){
        $size = getimagesize($photo);
        $height = $size[1];
        $width = $size[0];
        $res = array();
        $res['height']=intval($h);
        $res['width']=intval(($width*$h)/$height);

        return $res;
    }


    public function deleteImagesNotInDB2($path)
    {
        $images = $this->getAllImagesIntoArray();
        if(is_file($path)) {
            if(!in_array("/".$path, $images)){
                $this->deleteImage($path);
                $delete[]="/".$path;
            }else{
//dump("EXISTS");
                $noDelete[]=$path;
            }
        }elseif(is_dir($path)){
            $scanedFilesFolder = scandir($path);
            $filesFolder = array_diff($scanedFilesFolder, array('.', '..'));

            foreach ($filesFolder as $fileFolder) {
                $img = $path.'/'.$fileFolder;
                $this->deleteImagesNotInDB2($img);
            }
        }
    }
    public function getAllImagesIntoArray(){
        $em = $this->container->get('doctrine.orm.entity_manager');
        $images = $em->getRepository('NumaDOAAdminBundle:ItemField')->getLocalImages();
        $arrayImages = array();
        foreach($images as $image){

            $arrayImages[] = str_replace("//","/",$image->getFieldStringValue());
        }
        return $arrayImages;
    }

    public function deleteImage($filename){
        if(file_exists($filename)){
//            unlink($filename);
            //dump($filename);
        }
    }
    public function shrinkCoverImage($filename,$filter){
        $cachedImageUrl = "/media/cache/" . $filter ;
        $cachedPath = $this->container->get('kernel')->getRootDir() . "/../web".$cachedImageUrl;
        $origPath = $upload_path = $this->container->getParameter('web_path');

        $image = $filename;

        $cachedImage = $cachedPath . $image;
        $cachedImage = $this->cleanUrl($cachedImage);
        $cachedImageUrl = $cachedImageUrl.$image;
        $origImage = $origPath . $image;

        if (file_exists($origImage) && !file_exists($cachedImage)) {
            $processedImage = $this->container->get('liip_imagine.data.manager')->find('inventory_cover', $image);


            $newimage_string = $this->container->get('liip_imagine.filter.manager')->applyFilter($processedImage, 'inventory_cover')->getContent();
            $f = file_put_contents($cachedImage, $newimage_string);
            return $cachedImage;

        }

        if(file_exists($cachedImage)){
            return $cachedImageUrl;
        }
        return $filename;
    }

    public function cleanUrl($url){
        $result = str_replace('app/../', '', $url);
        $result = str_replace('//', '/', $url);
        return $result;
    }
}