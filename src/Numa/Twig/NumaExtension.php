<?php

// src/Rentabo/Twig/RentaboExtension.php

namespace Numa\Twig;

use Doctrine\Common\Collections\Criteria;
use Numa\DOAModuleBundle\Entity\Component;
use Numa\DOADMSBundle\Entity\DealerComponent;
use Numa\DOAModuleBundle\Entity\PageComponent;
use Numa\Util\Component\CarouselComponent;
use Numa\Util\Component\ComponentEntityInterface;
use Numa\Util\Component\ComponentView;
use Numa\Util\Component\ImageComponent;
use Numa\Util\Component\TextComponent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\ImageCarousel;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOASiteBundle\Services\ExtraListener;

class NumaExtension extends \Twig_Extension
{

    protected $container;
    protected $extraListener;

    public function __construct(ContainerInterface $container = null, ExtraListener $extraListener)
    {
        $this->container = $container;
        $this->extraListener = $extraListener;
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
            'displayComponent' => new \Twig_Function_Method($this, 'displayComponent', array('is_safe' => array('html'))),
            'displayCarouselComponent' => new \Twig_Function_Method($this, 'displayCarouselComponent'),
            'getDealer' => new \Twig_Function_Method($this, 'getDealer'),
            'shortWord' => new \Twig_Function_Method($this, 'shortWord'),
            'getPage' => new \Twig_Function_Method($this, 'getPage'),
            'isLocalHost' => new \Twig_Function_Method($this, 'isLocalHost'),
            'isQBReady' => new \Twig_Function_Method($this, 'isQBReady'),
            'addWWW' => new \Twig_Function_Method($this, 'addWWW'),
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

    public function price($price, $html = true)
    {
        $price = intval($price);
        if (empty($price)) {
            $price = "No price";
        } else {
            setlocale(LC_MONETARY, 'en_US');
            //$price = money_format('%i', floatval($price));
            //$price = "$" . $price;
            $price = "$" . number_format(floatval($price), 0, ".", ",");
        }
        $return = $price;
        if ($html) {
            $return = '<span class="price">' . $price . '</span>';
        }
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
        return "https://www.youtube.com/embed/" . $id;
    }


    public function getPage()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $request = $this->container->get("request");

        $pathinfo = $request->getPathInfo();
        if (substr($pathinfo, 0, 2) === "/x") {
            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
        }
        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();

        $dealer_id = null;
        if ($dealer instanceof Catalogrecords) {
            $dealer_id = $dealer->getId();
        }
        $page = $em->getRepository('NumaDOAModuleBundle:Page')->findPageByUrl2($pathinfo, $dealer_id);

        return $page;
    }

    public function displayComponent($name, $type = "Text", $source = "page", $theme = null, $setting = array())
    {

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("name", $name));//->getMaxResults(1);
        if (strtolower($type) == "carousel") {
            $criteria->andWhere(Criteria::expr()->eq("name", $name));
        }
        $request = $this->container->get("request");

        $pathinfo = $request->getPathInfo();

        if (substr($pathinfo, 0, 2) === "/x") {
            $pathinfo = substr($pathinfo, 2, strlen($pathinfo) - 1);
        }
        $em = $this->container->get('doctrine.orm.entity_manager');

        $dealer = $this->container->get("numa.dms.user")->getDealerByHost();

        $dealer_id = null;
        $page = null;
        $component = null;
        $value = "";

        if ($dealer instanceof Catalogrecords) {
            if ($source == "page") {
                //$component = $em->getRepository('NumaDOAModuleBundle:Page')->findPageComponentByUrl($pathinfo, $dealer->getId(),$name);
                $component = $this->container->get("mymemcache.dealer")->getPageComponent($pathinfo,$dealer->getId(),$name);

            } elseif ($source == "dealer") {
                //$component = $em->getRepository('NumaDOADMSBundle:DealerComponent')->findOneBy(array('Dealer'=>$dealer,'name'=>$name));
                $component = $this->container->get("mymemcache.dealer")->getDealerComponent($dealer,$name);

            }

        }


        if (!($component instanceof ComponentEntityInterface)) {

            $page = $this->container->get("mymemcache.dealer")->getPageByUrl($pathinfo, $dealer);
dump($page);
dump($name);
            if ($source == "page" && $page instanceof Page) {


                $component = new Component();
                $component->setName($name);
                $component->setType($type);
                $component->setTheme($theme);
                $pc = new PageComponent();
                $pc->setComponent($component);
                $pc->setPage($page);
                $em->persist($component);
                $em->persist($pc);
                $em->flush();
                $value = $component->getValue();
            } elseif ($source == "dealer") {

                $component = new DealerComponent();
                $dealer = $em->getRepository(Catalogrecords::class)->find($dealer->getId());

                $component->setDealer($dealer);
                $component->setName($name);
                $component->setTheme($theme);
                $component->setType($type);
                $em->persist($component);

                $em->flush();
                $value = $component->getValue();
            }
            //return $value;
        } else {
            if (!empty($theme) && ($component instanceof Component || $component instanceof DealerComponent) && strtolower($component->getTheme()) !== strtolower($theme)) {
                $component->setTheme($theme);
                $em->flush();
            }
            $value = $component->getValue();

        }

        if (empty($value)) {
            $value = "";
        }

        $componentxxx = null;

        if(strtolower($type)=="text" || strtolower($type)=="html"  || strtolower($type)=="template"){

            $componentxxx =new TextComponent($component);
            //return $componentxxx;
        }elseif(strtolower($type)=="carousel"){
            $componentxxx =new CarouselComponent($component);
            $componentxxx->setContainer($this->container);
            $componentxxx->setSettings($setting);
            //return $componentxxx;
        }elseif(strtolower($type)=="image"){
  //          dump("IMAGE");
            $componentxxx =new ImageComponent($component);
            $componentxxx->setContainer($this->container);
            $componentxxx->setSettings($setting);

            //return $componentxxx;
        }

        if ($componentxxx instanceof ComponentView) {

            $text = $componentxxx->display();
            return $text;
        }
        return "";

    }

    private function componentWrapper($component)
    {
//        $id = "c-".$component->getId();
//        $class = "componentx";
//        $html = "";
//        if($component instanceof Component){
//            $id = "dc-".$component->getId();
//            $class = "dealer-componentx";
//        }
//        $html = '<div id="'.$id.'" class="'.$class.'">'.$component->getValue()."</div>";

        //return $html;
        if ($component instanceof ComponentEntityInterface) {
            return $component->getValue();
        }
        return "";
    }

    public function getDealer()
    {
        $session = $this->container->get('session');
        $dealer_id = $session->get('dealer_id');
        $em = $this->container->get('doctrine.orm.entity_manager');
        $dealer = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerById($dealer_id);
        return $dealer;
    }

    public function shortWord($str, $chars)
    {
        $pieces = explode(" ", $str);
        $pieces = preg_split("/[-;, ]+/", $str);
        $len = 0;
        $ret = "";
        foreach ($pieces as $word) {
            $len = $len + strlen($word);

            if ($len > $chars) {
                return $ret;
            }
            $ret = $ret . " " . $word;
        }
        return $ret;
    }

    public function isLocalHost(){
        return $this->container->get("numa.dms.user")->isLocalHost();
    }

    public function isQBReady(Catalogrecords $dealer){
        return $this->container->get("numa.dms.user")->isQBReady($dealer);
    }

    public function addWWW($url){

        if(stripos($url,"www")===false && stripos($url,"dealersonair")===false){
            if(stripos($url,"http://")===false){
                $url ="www.".$url;
            }else {
                $url = str_replace("http://", "http://www.", $url);
            }
        }

        return $url;
    }

}

?>
