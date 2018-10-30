<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 19.12.16.
 * Time: 18.18
 */

namespace Numa\DOADMSBundle\Lib;


use mikehaertl\pdftk\Pdf;
use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\BillingDoc;
use Numa\DOADMSBundle\Entity\Customer;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Numa\DOADMSBundle\Entity\FillablePdfField;
use Numa\DOADMSBundle\Entity\Media;
use Numa\DOADMSBundle\Entity\SaveSearch;
use Numa\DOADMSBundle\Util\containerTrait;
use Numa\Util\searchESParameters;
use Numa\Util\SearchItem;

class SaveSearchLib
{
    use containerTrait;

    public function checkSaveSearchForDealer(SaveSearch $saveSearch){
        $em = $this->getContainer()->get('doctrine')->getManager();
        $dealer = $saveSearch->getDealer();

        //
    }

    public function getItemsForSaveSearch(SaveSearch $saveSearch){
        $em = $this->getContainer()->get('doctrine')->getManager();
        $make = strtolower($saveSearch->getMake());
        $dealer = $saveSearch->getDealer();
        $model = strtolower($saveSearch->getModel());
        $yearFrom = $saveSearch->getYearFrom();
        $yearTo = $saveSearch->getYearTo();

        //$items = $em->getRepository(Item::class)->find();
        $searchParameters = new searchESParameters($this->container);
        $searchParameters->set('yearFrom',new SearchItem('year',$yearFrom,'rangeFrom'));
        $searchParameters->set('yearTo',new SearchItem('year',$yearTo,'rangeTo'));
        $searchParameters->set('model',new SearchItem('model',$model));
        $searchParameters->set('make',new SearchItem('make',$make));
        if($dealer instanceof Catalogrecords) {
            $searchParameters->set('dealer_id', new SearchItem('dealer_id', $dealer->getid()),'int');
        }
        $result = $searchParameters->createElasticSearchResults();
        $res = $searchParameters->getResults()->getResults();
        $params = $searchParameters->getParams();
        dump(count($params));
        dump($res);

        $eq = $searchParameters->getElasticaQuery();
        dump($eq);
    }
}