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
}