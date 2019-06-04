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

    public function getAggregationsAction(Request $request){
//        $esp = new searchESParameters($this->container);
//
//        $parameters=array();
//        $parameters['featured']=1;
//        $queryParam = $request->query->all();
//        $esp->mergeParameters($request);
//        $esp->createElasticSearchResults();
//        $res = $esp->getResults()->getResults();
//
//
//
//        $make = "";
//        if(!empty($queryParam['make'])) {
//            $make = $queryParam['make'];
//        }
//        $esp = new searchESParameters($this->container);
//        $search = $this->get('fos_elastica.index.app.item');
//
//
//
//        $elasticaAggMake = new \Elastica\Aggregation\Terms('make');
//        $elasticaAggMake->setField('make');
//        $elasticaAggMake->setSize(100);
//        $elasticaAggMake->setOrder("_term","asc");
//        $elasticaQuery->addAggregation($elasticaAggMake);
//
//        $elasticaAggModel = new \Elastica\Aggregation\Terms('model');
//        $elasticaAggModel->setField('model');
//        $elasticaAggModel->setSize(100);
//        $elasticaAggModel->setOrder("_term","asc");
//        $elasticaQuery->addAggregation($elasticaAggModel);
//        // Get Aggregations
//
//        $elasticaResultSet = $search->search($elasticaQuery);
//        $elasticaAggregs = $elasticaResultSet->getAggregations();
//        $res = array();
//
//        if(!empty($elasticaAggregs) && !empty($elasticaAggregs['make']['buckets'])){
//            foreach($elasticaAggregs['make']['buckets'] as $make){
//                $temp = array('name'=>ucfirst($make['key']), 'id'=>$make['key'], 'count'=>$make['doc_count']);
//                $res['make'][] =    $temp;
//            }
//
//        }
//
//        if(!empty($elasticaAggregs) && !empty($elasticaAggregs['model']['buckets'])){
//            foreach($elasticaAggregs['model']['buckets'] as $model){
//                $temp = array('name'=>ucfirst($model['key']), 'id'=>$model['key'], 'count'=>$model['doc_count']);
//                $res['model'][] =    $temp;
//            }
//
//        }
//
//        return new JsonResponse($res,200,array("Access-Control-Allow-Origin"=>"*"));
    }
}