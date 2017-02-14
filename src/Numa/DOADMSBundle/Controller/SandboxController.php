<?php

namespace Numa\DOADMSBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wheniwork\OAuth1\Client\Server\Intuit;

class SandboxController extends Controller
{
    public function indexAction(Request $request)
    {
        $server = new \Wheniwork\OAuth1\Client\Server\Intuit(array(
            'identifier'   => 'qyprd5kDh2hG89BYGV3zawcxjF3srW',
            'secret'       => 'ysIIAnLN7z6XFi3mExYiVbOoPJnLB4UFoiWOPVIF',
            'callback_uri' => 'http://doa.local/dms/sandbox/oauth_redirect',
        ));

        // Retrieve temporary credentials
        $temporaryCredentials = $server->getTemporaryCredentials();
        $this->get("session")->set("temporary_credentials",serialize($temporaryCredentials));
        $this->get("session")->set("server",serialize($server));

        $server->authorize($temporaryCredentials);
        die();
        //$server = new \Wheniwork\OAuth1\Client\Server\Intuit()

    }

    public function oauthAction(Request $request)
    {
        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
            // Retrieve the temporary credentials we saved before
            $temporaryCredentials = unserialize($this->get("session")->get("temporary_credentials"));

            // We will now retrieve token credentials from the server
            $server = unserialize($this->get("session")->get('server'));


            $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
            dump($tokenCredentials);
            $this->get("session")->set('token_credential',serialize($tokenCredentials));
            die();
            dump($_GET['oauth_token']);
            dump($_GET['oauth_verifier']);


        }
die();
    }

    public function testAction(){
        $tokenCredentials = unserialize($this->get("session")->get('token_credential'));
        $server = unserialize($this->get("session")->get('server'));

        //$user = $server->getUserDetails($tokenCredentials);
        //dump($user);
        $url = "https://sandbox-quickbooks.api.intuit.com/v3/company/123145730610364/account/1";
        $url = "https://sandbox-quickbooks.api.intuit.com/v3/company/193514471433949/customer/1";
        $client = $server->createHttpClient();



        $headers = $server->getHeaders($tokenCredentials, 'GET', $url);
        $headers['Accept'] = 'application/json';
        $buzz = $this->get("buzz")->get($url,$headers);
        //dump($buzz->getContent());
        dump($tokenCredentials);
        dump($buzz);
        die();
        return new JsonResponse(json_decode($buzz->getContent()));
        die();
        $response = $client->get($url, [
            'headers' => $headers,
        ]);
        $content = $response->getBody()->getContents();
        $json = json_decode((string) $response->getBody(), true);
        $xml =  simplexml_load_string((string) $response->getBody());
        $xml2 =  ((string) $response->getBody());
dump($xml2);
        die();
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $xml);

        $fileContents = trim(str_replace('"', "'", $fileContents));

        $simpleXml = simplexml_load_string($fileContents);
        //dump($simpleXml);
        $json = json_encode($xml);
        //dump($json);
        //dump($xml);
        //$obj = json_decode($content);
        //dump($obj);
        //dump($content);
        return new JsonResponse($json);

    }

}
