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

    public function findQBCustomerByCompanyName($companyName)
    {
        return $this->findQBEntityByField('Customer', 'CompanyName', $companyName);
    }

    public function findQBCustomerByFirstLastName($firstName, $lastName)
    {
        return $this->findQBEntityByField('Customer', 'DisplayName', $firstName . " " . $lastName);
    }

    public function insertCustomerToQBCustomer(Customer $customer)
    {
        $qbCustomer = $this->createQBCustomer($customer);

        return $this->insertQBCustomerToQB($qbCustomer);
    }

    public function createQBCustomer(Customer $customer)
    {

        $qbo = $this->container->get("numa.quickbooks")->init($this->dealer);

        $qbCustomer = $this->findUniqueQBCustomer($customer);

        if (!$qbCustomer instanceof \QuickBooks_IPP_Object_Customer) {
            $qbCustomer = new \QuickBooks_IPP_Object_Customer();
        }


        $qbCustomer->setGivenName($customer->getFirstName());

        $qbCustomer->setFamilyName($customer->getLastName());
        $qbCustomer->setDisplayName($customer->getName());


// Phone #
        $PrimaryPhone = new \QuickBooks_IPP_Object_PrimaryPhone();
        //$PrimaryPhone->setFreeFormNumber('860-532-0089');
        $qbCustomer->setPrimaryPhone($customer->getHomePhone());

// Mobile #
        $Mobile = new \QuickBooks_IPP_Object_Mobile();
        //$Mobile->setFreeFormNumber('860-532-0089');
        $qbCustomer->setMobile($customer->getMobilePhone());

// Fax #
        $Fax = new \QuickBooks_IPP_Object_Fax();
        //$Fax->setFreeFormNumber('860-532-0089');
        $qbCustomer->setFax($customer->getFax());

// Bill address
        $BillAddr = new \QuickBooks_IPP_Object_BillAddr();
        $BillAddr->setLine1($customer->getAddress());
        $BillAddr->setLine2($customer->getAddress2());
        $BillAddr->setCity($customer->getCity());
        //$BillAddr->setCountrySubDivisionCode('MI');
        $BillAddr->setPostalCode($customer->getZip());
        $qbCustomer->setBillAddr($BillAddr);

// Email
        $PrimaryEmailAddr = new \QuickBooks_IPP_Object_PrimaryEmailAddr();
        $PrimaryEmailAddr->setAddress($customer->getEmail());
        $qbCustomer->setPrimaryEmailAddr($PrimaryEmailAddr);
        return $qbCustomer;
    }

    public function findUniqueQBCustomer(Customer $customer)
    {

        if (!empty($customer->getEmail())) {
            return $this->findQBCustomerByEmail($customer->getEmail());
        }
        if (!empty($customer->getName())) {
            return $this->findQBCustomerByDisplayedName($customer->getName());
        }
        return "";
    }

    public function findQBCustomerByEmail($email)
    {
        return $this->findQBEntityByField('Customer', 'PrimaryEmailAddress', $email);
    }

    public function findQBCustomerByDisplayedName($displayedName)
    {

        return $this->findQBEntityByField('Customer', 'DisplayName', $displayedName);
    }

    public function insertQBCustomerToQB(\QuickBooks_IPP_Object_Customer $qbCustomer)
    {
        return $this->insertQBEntityToQB($qbCustomer);
    }

    public function setField(&$qbCustomer, $qbField, Customer $customer, $property)
    {
        $fn = "get" . ucfirst($property);
        $qbfn = "set" . ucfirst($qbField);
        if (method_exists($customer, $fn) && !empty($customer->{$fn}())) {
            if (method_exists($qbCustomer, $qbfn) && !empty($qbCustomer->{$qbfn}())) {
                $qbCustomer->{$qbfn}($customer->$qbCustomer->{$qbfn}());
            }
        }
    }
}