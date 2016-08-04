<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 21.7.16.
 * Time: 15.27
 */

namespace Numa\DOADMSBundle\Lib;
use Symfony\Component\HttpFoundation\Request;


class UiGrid
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

    public function getSelectedIds(Request $request){
        $data = json_decode($request->get('data'));

        $values =array();
        foreach($data as $item_id){
            $values[]=intval($item_id);
        }
        $item_ids = implode(",",$values);
        return $item_ids;
    }
}