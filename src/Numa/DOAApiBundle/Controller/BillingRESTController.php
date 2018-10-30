<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 24.8.15.
 * Time: 19.20
 */

namespace Numa\DOAApiBundle\Controller;

use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOADMSBundle\Entity\Billing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

class BillingRESTController extends Controller
{

    /**
     * @Rest\View
     */
    public function singleAction($id)
    {
        $billing = $this->getDoctrine()->getRepository('NumaDOADMSBundle:Billing')->find($id);
        return $billing;
    }

    /**
     * @Rest\View
     */
    public function byDealerAction($id)
    {
        $dealers_id = $this->get("numa.dms.user")->getAvailableDealersIds();
        $billings=null;
        $id = explode(",",$id);
        if(count($id)==1){
            $id=$id[0];
        }
        $dealers_id = explode(",",$dealers_id);

        if($id == $dealers_id || in_array($id,$dealers_id)) {

            $em = $this->getDoctrine()->getManager();

            $billings = $this->getDoctrine()->getRepository(Billing::class)->findByDealer($id);
        }
        return $billings;
    }

}