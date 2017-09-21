<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Customer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BillingLib
{
    use containerTrait;

    /**
     * Before it gets billing it checks if the dealer is the owner
     * @param $id
     * @return Billing
     * @throws createNotFoundException
     */
    public function getBilling($id){
        $dealersIds = $this->container->get("numa.dms.user")->getAvailableDealersIds();
        $billing = $this->em->getRepository('NumaDOADMSBundle:Billing')->findOneByIdAndDealersId($id,$dealersIds);

        if(!$billing instanceof Billing){
            throw new NotFoundHttpException("The requested billing has not been found");
        }
        return $billing;
    }
}