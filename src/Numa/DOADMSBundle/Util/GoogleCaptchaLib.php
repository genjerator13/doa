<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class GoogleCaptchaLib
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

    public function proccessGoogleCaptcha(Request $request, Form $form)
    {
//CAPTCHA
        $captcha = $request->get('g-recaptcha-response');

        $secret = $this->container->getParameter("google.captcha.secret");
        $url = $this->container->getParameter("google.captcha.url");

        $response = file_get_contents($url . "?secret=" . $secret . "&response=" . $captcha);
        $responseKeys = json_decode($response, true);

        if ($form->isValid() && intval($responseKeys["success"]) !== 1) {
            $form->addError(new FormError('CAPTCHA ERROR'));
        }
        return $form;
    }
}