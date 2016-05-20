<?php

// src/Rentabo/Twig/RentaboExtension.php

namespace Numa\Twig;

use Doctrine\Common\Collections\Criteria;
use Numa\DOADMSBundle\Entity\Component;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
            'getDealer' => new \Twig_Function_Method($this, 'getDealer'),
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

    public function displayComponent($components,$name)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("name", $name))
            ;//->getMaxResults(1);
        if(!empty($components)) {
            $componentsArray = $components->matching($criteria);

            if (!empty($componentsArray) and $componentsArray->count() > 0) {

                return $componentsArray->first()->getValue();
            }
        }
        return "c not f";
    }

    public function getDealer(){
        $session   = $this->container->get('session');
        $dealer_id = $session->get('dealer_id');
        $em        = $this->container->get('doctrine.orm.entity_manager');
        $dealer    = $em->getRepository('NumaDOAAdminBundle:Catalogrecords')->getDealerById($dealer_id);
        return $dealer;
    }

}

?>
