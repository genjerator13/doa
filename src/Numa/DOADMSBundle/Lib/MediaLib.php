<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Util\containerTrait;

class MediaLib
{
    use containerTrait;

    public function addMedia(){

    }

    public function addFillablePdf(){

    }

    public function showMedia(Media $media)
    {
        $templating = $this->container->get("templating");
        //dump("AAAA");die();
        return $templating->render('NumaDOADMSBundle:Media:media.pdf.twig', array(
            'media' => $media,
        ));
    }

    public function addMediaFromFile($filename){

        if(file_exists($filename)) {

            $em = $this->em;
            $media = $em->getRepository(Media::class)->findOneBy(array("name"=>basename($filename)));
            if(!$media instanceof Media) {
                $media = new Media();
                $em->persist($media);
            }
            $media->setName(basename($filename));
            $media->setMimetype(mime_content_type($filename));
            $content = file_get_contents($filename);
            $media->setContent(base64_encode($content));

            $em->flush();
            return $media;
        }

        return false;
    }

    public function addFillablePdfFromFile($filename){
        if(file_exists($filename)) {
            $em = $this->em;
            $media = $this->addMediaFromFile($filename);
            $fillablePdf = $em->getRepository(FillablePdf::class)->findOneBy(array("name"=>$media->getName()));
            if(!$fillablePdf instanceof FillablePdf) {
                $fillablePdf = new FillablePdf();
                $em->persist($fillablePdf);
            }
            $fillablePdf->setMedia($media);
            $fillablePdf->setName($media->getName());

            $em->flush();
            return $fillablePdf;
        }
        return false;
    }



}