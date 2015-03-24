<?php

namespace Numa\DOAAdminBundle\Controller;

use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Item controller.
 *
 */
class ExternalFeedController extends Controller {

    public function indexAction() {
        // create http client instance
        //$client = new Client('https://www.agedstock.com/services/edi/');
//        $client = new Client('https://www.agedstock.com/services/edi/',array(
//                    
//                'auth' => array('User Name'=>'MediaTech', 'Password'=>'CaHuVB9')                
//            
//        ));
        $client = new Client('https://www.agedstock.com/services/edi/',array('auth' => array('MediaTech', 'CaHuVB9')));             
            
        
        
//        $client = new Client(array(
//        'base_url' => 'https://api.twitter.com/{version}/',
//            'defaults' => array(
//                'auth' => array('username', 'password')
//            )
//        )
//        );
//        $client = new Client('http://webservice/url', array(
//            'defaults' => array(
//                'auth'    => array('username', 'password'),
//            )
//        ));
// create a request
        //$client->
        $request = $client->get();

// send request / get response
        $response = $request->send();

// this is the response body from the requested page (usually html)
        $result = $response->getBody();
        dump($result);
        return $this->render('NumaDOAAdminBundle:ExternalFeeds:index.html.twig', array());
    }

}
