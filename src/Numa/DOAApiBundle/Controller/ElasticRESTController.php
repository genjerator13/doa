<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;


use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOAAdminBundle\Entity\ItemField;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\Util\searchESParameters;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ElasticRESTController extends Controller
{
    const cacheMaxAge = 86400;

    public function getFeaturedAction($count=0)
    {

        $esp = new searchESParameters($this->container);

        $parameters=array();
        $parameters['featured']=1;

        $esp->setAll($parameters);
        $esp->createElasticSearchResults();
        $res = $esp->getResults()->getResults();


        if(!empty($count)){
            $rand_keys = array_rand($res, $count);
            $temp = $res;
            $res = array();
            foreach ($rand_keys as $key=>$value){
                //
                $res[] = $temp[$value]->getData();
            }

        }
        return new JsonResponse($res,200,array("Access-Control-Allow-Origin"=>"*"));
    }
}