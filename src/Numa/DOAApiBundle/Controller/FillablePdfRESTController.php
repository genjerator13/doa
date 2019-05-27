<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\FillablePdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;


class FillablePdfRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function allAction()
    {
        $component = $this->getDoctrine()->getRepository(FillablePdf::class)->findAll();
        return $component;
    }


}