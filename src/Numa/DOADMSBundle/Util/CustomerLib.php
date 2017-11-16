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
use Numa\DOADMSBundle\Entity\Customer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerLib
{
    use containerTrait;

    /**
     * @param $id
     * @return Customer
     * @throws createNotFoundException
     */
    public function getCustomer($id){
        $dealersIds = $this->container->get("numa.dms.user")->getAvailableDealersIds();
        $customer = $this->em->getRepository('NumaDOADMSBundle:Customer')->findOneByIdAndDealersId($id,$dealersIds);

        if(!$customer instanceof Customer){
            throw new NotFoundHttpException("The requested customer has not been found");
        }

        return $customer;
    }
}