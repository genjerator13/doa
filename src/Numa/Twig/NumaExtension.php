<?php

// src/Rentabo/Twig/RentaboExtension.php

namespace Numa\Twig;

use Doctrine\Common\Collections\Criteria;
use Numa\DOADMSBundle\Entity\Component;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Numa\DOAAdminBundle\Entity\Catalogrecords;

class NumaExtension extends \Twig_Extension
{

    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'showItemField' => new \Twig_Function_Method($this, 'showItemField'),
            'dumpFields' => new \Twig_Function_Method($this, 'dumpFields'),
            'price' => new \Twig_Function_Method($this, 'price'),
            'file_existsx' => new \Twig_Function_Method($this, 'file_existsx'),
            'memcacheGet' => new \Twig_Function_Method($this, 'memcacheGet'),
            'getYoutubeId' => new \Twig_Function_Method($this, 'getYoutubeId'),
            'getYoutubeThumb' => new \Twig_Function_Method($this, 'getYoutubeThumb'),
            'getYoutubeEmbed' => new \Twig_Function_Method($this, 'getYoutubeEmbed'),
            'displayComponent' => new \Twig_Function_Method($this, 'displayComponent'),
            'displayCarouselComponent' => new \Twig_Function_Method($this, 'displayCarouselComponent'),
            'getDealer' => new \Twig_Function_Method($this, 'getDealer'),
            'shortWord' => new \Twig_Function_Method($this, 'shortWord'),
        );
    }

    public function file_existsx($filename)
    {
        return file_exists(trim($filename, "/"));
    }

    public function memcacheGet($key)
    {
        //$this->get('mymemcache')
        $memcached = $this->container->get('mymemcache');
        $value = $memcached->get($key);
        return $value;
    }

    public function showItemField($itemFields, $fieldname, $type = 'string')
    {
        $res = "";
        $fieldname = strtolower($fieldname);
        if (!empty($itemFields[$fieldname])) {
            if (count($itemFields[$fieldname]) == 1) {
                $itemfieldObject = $itemFields[$fieldname][0];
                $res = $itemfieldObject->getFieldStringValue();
                return $res;
            }
        }
        return $res;;
    }

    public function dumpFields($itemFields)
    {
        $res = "sss";
        foreach ($itemFields as $key => $item) {
            $res .= $key . ".</br>";
        }
        return $res;
    }

    public function getName()
    {
        return 'numa_extension';
    }

    public function price($price)
    {
        $price = intval($price);
        if (empty($price)) {
            $price = "No price";
        } else {
            setlocale(LC_MONETARY, 'en_US');
            $price = money_format('%i', floatval($price));
            $price = "$ " . number_format(floatval($price), 0, ",", ",");
        }
        $return = '<span class="price">' . $price . '</span>';
        return $return;
    }

    public function getYoutubeId($youtube)
    {
        $matches = array();
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $youtube, $matches);
        if (!empty($matches[0])) {
            return $matches[0];
        }
        return false;
    }

    public function getYoutubeThumb($id)
    {
        return "http://img.youtube.com/vi/" . $id . "/0.jpg";
    }

    public function getYoutubeEmbed($id)
    {
        //https://www.youtube.com/embed/xH01UCfId0A
        return "https://www.youtube.com/embed/".$id;
    }

    public function displayComponent($name)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("name", $name))
            ;//->getMaxResults(1);
        $request = $this->container->get("request");
        //dump($request);
        $pathinfo = $request->getPathInfo();

        if (substr($pathinfo, 0, 2) === "/d") {
            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
        }
        $em = $this->container->get('doctrine.orm.entity_manager');
        $host = trim(strip_tags($request->getHost()));
        $dealer = $em->getRepository("NumaDOAAdminBundle:Catalogrecords")->getDealerByHost($host);


        $dealer_id = null;
        $pcomponents = array();
        $dcomponents = array();

        if ($dealer instanceof Catalogrecords) {
            $pcomponents = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId());
            $dcomponents = $dealer->getComponent();
        }
        //dump($dealer->getComponent());die();
//        $components['page'] = $pcomponents;
//        $components['dealer'] = $dcomponents;
        //$componentRes = "c not f";

        if(!empty($pcomponents)) {
            $componentsArray = $pcomponents->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {

                return $componentsArray->first()->getValue();
            }
        }

        if(!empty($dcomponents)) {

            $componentsArray = $dcomponents->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {

                return  $componentsArray->first()->getValue();
            }
        }

        return "c not f";
    }

    public function displayCarouselComponent($components){
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("type", 'Carousel'));//->getMaxResults(1);

        if(!empty($components)) {
            $componentsArray = $components->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {

                $component =  $componentsArray->first();

                $em        = $this->container->get('doctrine.orm.entity_manager');
                $images    = $em->getRepository("NumaDOAAdminBundle:ImageCarousel")->findByComponent($component->getId());

                return $images;
            }
        }
        return null;
    }

    public function getDealer(){
        $session   = $this->container->get('session');
        $dealer_id = $session->get('dealer_id');
        $em        = $this->container->get('doctrine.orm.entity_manager');
        $dealer    = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerById($dealer_id);
        return $dealer;
    }

    public function shortWord($str,$chars){
        $pieces = explode(" ", $str);
        $pieces = preg_split("/[-;, ]+/", $str);
        $len = 0;
        $ret="";
        foreach($pieces as $word){
            $len = $len + strlen($word);

            if($len>$chars){
                return $ret;
            }
            $ret = $ret." ".$word;
        }
        return $ret;

    }

}

?>
