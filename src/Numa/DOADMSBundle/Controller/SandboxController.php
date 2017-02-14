<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {

            $buzz = $this->container->get('buzz');
            $error = "";
            $url = 'https://oauth.intuit.com/oauth/v1/get_request_token?'.
'oauth_callback=https%3A%2F%2Fdoa.local/dms/sandbox/oautr-redirect&'.
'oauth_consumer_key=qyprd5kDh2hG89BYGV3zawcxjF3srW&'.
'oauth_nonce=JbQrn8&'.
'oauth_signature=ysIIAnLN7z6XFi3mExYiVbOoPJnLB4UFoiWOPVIF&'.
'oauth_signature_method=HMAC-SHA1&'.
'oauth_timestamp='.time().'&'.
'oauth_version=1.0';
echo $url."::::::::::";//die();
            $response = $buzz->get($url);
        dump( $response);
        die();
            $param = array();
            $param['o$urlauth_callback'] =  'http://doa.local/dms/sandbox/oautr-redirect';
            $param['oauth_consumer_key'] = 'qyprd5kDh2hG89BYGV3zawcxjF3srW';
            $param['oauth_nonce'] = 'JbQrn8';
            $param['oauth_signature'] = 'ysIIAnLN7z6XFi3mExYiVbOoPJnLB4UFoiWOPVIF';
            $param['oauth_signature_method'] = 'HMAC-SHA1&';
            $param['oauth_timestamp'] = time();
            $param['oauth_version'] = "1.0";
            $response->setHeaders($param);


            echo ($response->getContent());die();
//        //} catch (Exception $ex) {
//            //$error['ERROR'] = "NO CONNECTION";
//           // return $error;
//        //}

        return $this->render('NumaDOADMSBundle:Sandbox:index.html.twig');

    }

}
