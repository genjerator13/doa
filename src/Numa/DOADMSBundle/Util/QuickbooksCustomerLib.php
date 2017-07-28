<?php
/**
 * Created by PhpStorm.
 * User: genjerator
 * Date: 14.10.16.
 * Time: 16.44
 */

namespace Numa\DOADMSBundle\Util;


use Numa\DOAAdminBundle\Entity\Catalogrecords;
use Numa\DOAAdminBundle\Entity\Item;
use Numa\DOADMSBundle\Entity\Billing;
use Numa\DOADMSBundle\Entity\Customer;

class QuickbooksCustomerLib extends QuickbooksLib
{

    public function createQBCustomer(Customer $customer)
    {

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $qbCustomer = $this->findQBCustomerByEmail($customer->getEmail());

        if (!$qbCustomer instanceof \QuickBooks_IPP_Object_Customer) {
            $qbCustomer = new \QuickBooks_IPP_Object_Customer();
        }


        return $qbCustomer;
    }

    public function findQBCustomerByEmail($email)
    {
        return $this->findQBEntityByField('Customer', 'email',$email);
    }

    public function findQBCustomerByCompanyName($companyName)
    {
        return $this->findQBEntityByField('Customer', 'CompanyName',$companyName);
    }

    public function findQBCustomerByFirstLastName($firstName,$lastName)
    {
        return $this->findQBEntityByField('Customer', 'DisplayName',$firstName." ".$lastName);
    }

    public function insertCustomerToQBCustomer(Customer $customer)
    {
        $qbCustomer = $this->createQBCustomer($customer);
        return $this->insertQBCustomerToQB($qbCustomer);
    }

    public function insertQBCustomerToQB(\QuickBooks_IPP_Object_Customer $qbCustomer)
    {
        $customerService = new \QuickBooks_IPP_Service_Customer();
        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        if (empty($qbCustomer->getId())) {
            if ($resp = $customerService->add($qbo->getContext(), $qbo->getRealm(), $qbCustomer)) {
                return $qbCustomer;
            } else {
                dump('SaleReceipt add failed...? ' . $SaleService->lastError());
                return false;
            }
        } else {
            if ($resp = $customerService->update($qbo->getContext(), $qbo->getRealm(), $qbCustomer->getId(), $qbCustomer)) {
                return $qbCustomer;
            } else {
                dump('SaleReceipt update failed...? ' . $customerService->lastError());
                return false;
            }
        }

        return $qbCustomer;
    }


}