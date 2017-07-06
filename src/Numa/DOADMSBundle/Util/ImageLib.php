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
    protected $delete=array();
    protected $nodelete=array();

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


    public function deleteImagesNotInDB()
    {
        $images = $this->getAllImagesIntoArray();
        $dir    = 'upload/itemsimages'; // path from top
        $scanedFiles = scandir($dir);
        $files = array_diff($scanedFiles, array('.', '..'));
        $delete=array();
        $noDelete=array();

        foreach($files as $file){
            // "is_dir" only works from top directory, so append the $dir before the file
            if (is_dir($dir.'/'.$file)){
                $scanedFilesFolder = scandir($dir.'/'.$file);
                $filesFolder = array_diff($scanedFilesFolder, array('.', '..'));
                foreach ($filesFolder as $fileFolder) {
                    $img = $dir.'/'.$file.'/'.$fileFolder;
                    //dump('/'.$img);
                    if(!in_array('/'.$img, $images)){
                        $this->deleteImage($img);
                        $delete[]=$img;
                        //dump("not EXISTS");
                    }else{
                        $noDelete[]=$img;
//                        dump("EXISTS");
//                        dump($img);
                    }
                }

            } else{
                $img = $dir.'/'.$file;
                //dump('/'.$img);
                if(!in_array('/'.$img, $images)){
                    $this->deleteImage($img);
                    $delete[]=$img;
                }else{
                    //dump("EXISTS");
                    $noDelete[]=$img;
                }
            }
        }
        dump("DELETE");
        dump($delete);
        dump("no DELETE");
        dump($noDelete);
        die();

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
        if(!empty($filename)) {
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
                $this->container->get('liip_imagine.cache.manager')->store($newimage, $filename,$filter);
                $image = $this->container->get('liip_imagine.cache.manager')->getBrowserPath($filename,$filter);

                return $image;

            }

            if (file_exists($cachedImage)) {
                return $cachedImageUrl;
            }
        }
        return $filename;
    }

    public function cleanUrl($url){
        $result = str_replace('app/../', '', $url);
        $result = str_replace('//', '/', $result);
        return $result;
    }
}