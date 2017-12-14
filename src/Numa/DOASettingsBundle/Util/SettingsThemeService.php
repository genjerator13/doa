<?php
namespace Numa\DOASettingsBundle\Util;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAModuleBundle\Entity\Page;
use Numa\DOAModuleBundle\Entity\Seo;
use Numa\DOASettingsBundle\Entity\Setting;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;

class SettingsThemeService
{
    /**
     * @var EntityManager
     */
    protected $em;
    protected $container;
    /**
     * @var EntityRepository
     */
    protected $repo;

    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->repo = null;
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = null;
    }

    public function mainTitle(){
        return $this->container->get('numa.settings')->getStripped('main_title');
    }

    public function featuredTitle(){
        return $this->container->get('numa.settings')->getStripped('featured_title');
    }

    public function middleText(){
        return $this->container->get('numa.settings')->get('middle_text');
    }

    public function button($i){
        return $this->container->get('numa.settings')->get('button'.$i);
    }

    public function bridgeMainTitle(){
        $title = $this->mainTitle();
        if(empty($title)){
            $title = "Browse Our Huge Stock of Commercial Trucks and Vans";
        }
        return $title;
    }

    public function bridgeFeaturedTitle(){
        $title = $this->featuredTitle();
        if(empty($title)){
            $title = "Vehicles on Special";
        }
        return $title;
    }

    public function bridgeMiddleText(){
        $text = $this->middleText();
        if(empty($text)){
            $text = "<h2>Used Commercial Vehicles in Saskatoon, Saskatchewan</h2>
                        <p>At Saskatoon Truck Centre, just 12 kilometers south of the city on Highway 11, we are the province’s largest source for commercial trucks and vans. Tradespeople from all across Regina, Swift Current, Moose Jaw, and North Battleford come to us for their specific pre-owned work vehicle from Chevrolet, GMC, Ford, RAM, Mercedes-Benz Sprinter, and Mitsubishi in the following gas and diesel configurations:</p>
                        <ul>
                            <li>Half, three-quarter, and one ton pick ups</li>
                            <li>Flat decks</li>
                            <li>Cargo vans</li>
                            <li>Cube vans</li>
                            <li>Chassis cabs</li>
                        </ul>";
        }
        return $text;
    }
/*
 <div class="button">
                        <a href="/browse_by_truck_van_type/cargo van" class="btn btn-bridge-red">Cargo Vans</a>
                    </div>
                    <div class="button">
                        <a href="/browse_by_truck_van_type/cube van" class="btn btn-bridge-red">Cube Vans</a>
                    </div>
                    <div class="button">
                        <a href="/browse_by_truck_van_type/passenger van" class="btn btn-bridge-red">Passenger Vans</a>
                    </div>
                    <div class="button">
                        <a href="/browse_by_truck_van_type/chassis cab" class="btn btn-bridge-red">Chassis Cabs</a>
                    </div>
                    <div class="button">
                        <a href="/browse_by_truck_van_type/pickup" class="btn btn-bridge-red">Pickup</a>
                    </div>
 */
    public function bridgeButton1(){
        $text = $this->button(1);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/flat deck\" class=\"btn btn-bridge-red\">Flat Decks</a>
                    </div>

                    ";
        }
        return $text;
    }

    public function bridgeButton2(){
        $text = $this->button(2);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/cube van\" class=\"btn btn-bridge-red\">Cube Vans</a>
                    </div>

                    ";
        }
        return $text;
    }
    public function bridgeButton3(){
        $text = $this->button(3);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/passenger van\" class=\"btn btn-bridge-red\">Passenger Vans</a>
                    </div>

                    ";
        }
        return $text;
    }

    public function bridgeButton4(){
        $text = $this->button(4);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/chassis cab\" class=\"btn btn-bridge-red\">Chassis Cabs</a>
                    </div>

                    ";
        }
        return $text;
    }

    public function bridgeButton5(){
        $text = $this->button(5);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/pickup\" class=\"btn btn-bridge-red\">Pickup</a>
                    </div>

                    ";
        }
        return $text;
    }

    public function bridgeButton6(){
        $text = $this->button(6);
        if(empty($text)){
            $text = "<div class=\"button\">
                        <a href=\"/browse_by_truck_van_type/passenger van\" class=\"btn btn-bridge-red\">Passenger Vans</a>
                    </div>

                    ";
        }
        return $text;
    }

    public function isCentralAuto(){
        return !empty($this->bridgeMainTitle());
    }
}