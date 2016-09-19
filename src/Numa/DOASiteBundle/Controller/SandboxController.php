<?php

namespace Numa\DOASiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Numa\Util\Util as Util;
//use Guzzle
use Guzzle\Http\Client;
use Lsw\GuzzleBundle\LswGuzzleBundle;
use Elastica\Facet\Terms;
use Elastica\Query;
use Elastica\Query\Elastica_Query_Terms;
use Symfony\Component\HttpFoundation\Response;


class SandboxController extends Controller
{

    public function indexAction()
    {
//        $data = array('key' => '16ab1a10-2daf-0130-dd76-005056be005f', 'password' => 'arkansas22');
//        $data = array('key' => 'c0bf5ed0-2453-0133-0595-005056be005e', 'password' => 'arkansas22');
//        $data = array('key' => 'acd95d50-8bc3-0133-346d-005056be003c', 'password' => 'arkansas22');
//        $url = "http://www.machinefinder.com/dealer_families/6926/machine_feed.xml";
//        $handle = curl_init($url);
//        curl_setopt($handle, CURLOPT_POST, true);
//        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
//        curl_exec($handle);
//        die();
        $em = $this->getDoctrine()->getManager();
        $cover = $em->getRepository("NumaDOAAdminBundle:Item")->getCoverPhoto(40044);
        dump($cover);
        die();
    }

    public function test2Action()
    {
        $client = new Client($this->container->get('router')->getContext()->getScheme() . "://" . $this->container->get('router')->getContext()->getHost());

        $req = $client->get('/api/customer/all.json');
        $response = $req->send();
        //dump($this->container->get('router')->getContext()->getScheme()."://".$this->container->get('router')->getContext()->getHost());
        $restClient = $this->container->get('circle.restclient');

        $test = $restClient->get($this->container->get('router')->getContext()->getScheme() . "://" . $this->container->get('router')->getContext()->getHost() . '/api/ads/all.json');
        //$test->;
        return new JsonResponse($response->json());
        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());

    }

    public function testAction()
    {

        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('NumaDOAStatsBundle:Stats')->find(7);
//        dump($customer->getLastnoteadded());die();
        $response = $this->render('NumaDOASiteBundle:Sandbox:test.html.twig', array());

        return $response;
    }

    public function test3Action()
    {

        $repositoryManager = $this->container->get('fos_elastica.manager');

        /** var FOS\ElasticaBundle\Repository */
        $repository = $repositoryManager->getRepository('Numa\DOAAdminBundle\Entity\Item');

        $item = $this->get('fos_elastica.index.app.item');

        $query_part = new \Elastica\Query\Bool();
        $query_part->addShould(
            new \Elastica\Query\Term(array('status' => array('value' => 'new', 'boost' => 3)))
        );
        $item->search($query_part);


        $filters = new \Elastica\Filter\Bool();
        $query = new \Elastica\Query\Filtered($query_part, $filters);

        $resultSet = $item->search($query);
//        foreach ($resultSet as $result) {
//            dump($result);
//        }
        ///dump($test);
        $this->maxDifference();
        //die();
        return new Response();
    }

    function maxDifference()
    {

        $index = $this->get('fos_elastica.index.app.item');
        $finder = $this->get('fos_elastica.finder.app.item');

        $query = new \Elastica\Query();
        $boolQuery = new \Elastica\Query\BoolQuery();

        $fieldQuery = new \Elastica\Query\Match();
        $filter = new \Elastica\Filter\BoolAnd();
        $boolFilter = new \Elastica\Filter\Bool();

        // Term search
        // Search Result by title
        $titleTerm  = new \Elastica\Filter\Term();
        $titleTerm->setTerm("status", 'new');
        $boolFilter->addMust($titleTerm);

        $filter->addFilter($boolFilter);
        $filteredQuery = new \Elastica\Query\Filtered(null, $filter);
        $query->setQuery($filteredQuery);
        $query->setSize(100);
        $posts = $finder->find($query);

        // posts return all filterd results
        dump($posts);

    }

    function balanceSum($A)
    {
        print_r($A);
        $n = $A[0];
        array_shift($A);
        for ($i = 1; $i < $n; $i++) {
            $left = array_slice($A, 0, $i);
            $right = array_slice($A, $i + 1, $n);
            $leftSum = array_sum($left);
            $rightSum = array_sum($right);
            if ($leftSum == $rightSum) {
                return $i;
            }
            dump($left);
            dump($right);
        }
    }

}


