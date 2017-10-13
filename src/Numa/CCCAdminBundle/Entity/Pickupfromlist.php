<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pickupfromlist
 */
class Pickupfromlist
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $addr1;

    /**
     * @var string
     */
    private $addr2;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $prov;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $pcode;

    /**
     * @var string
     */
    private $ref;

    /**
     * @var string
     */
    private $srv;

    /**
     * @var string
     */
    private $costcode;

    /**
     * @var string
     */
    private $instru1;

    /**
     * @var string
     */
    private $instru2;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var string
     */
    private $taxcode;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $email;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return Pickupfromlist
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Pickupfromlist
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Pickupfromlist
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set addr1
     *
     * @param string $addr1
     * @return Pickupfromlist
     */
    public function setAddr1($addr1)
    {
        $this->addr1 = $addr1;

        return $this;
    }

    /**
     * Get addr1
     *
     * @return string 
     */
    public function getAddr1()
    {
        return $this->addr1;
    }

    /**
     * Set addr2
     *
     * @param string $addr2
     * @return Pickupfromlist
     */
    public function setAddr2($addr2)
    {
        $this->addr2 = $addr2;

        return $this;
    }

    /**
     * Get addr2
     *
     * @return string 
     */
    public function getAddr2()
    {
        return $this->addr2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Pickupfromlist
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set prov
     *
     * @param string $prov
     * @return Pickupfromlist
     */
    public function setProv($prov)
    {
        $this->prov = $prov;

        return $this;
    }

    /**
     * Get prov
     *
     * @return string 
     */
    public function getProv()
    {
        return $this->prov;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Pickupfromlist
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set pcode
     *
     * @param string $pcode
     * @return Pickupfromlist
     */
    public function setPcode($pcode)
    {
        $this->pcode = $pcode;

        return $this;
    }

    /**
     * Get pcode
     *
     * @return string 
     */
    public function getPcode()
    {
        return $this->pcode;
    }

    /**
     * Set ref
     *
     * @param string $ref
     * @return Pickupfromlist
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return string 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set srv
     *
     * @param string $srv
     * @return Pickupfromlist
     */
    public function setSrv($srv)
    {
        $this->srv = $srv;

        return $this;
    }

    /**
     * Get srv
     *
     * @return string 
     */
    public function getSrv()
    {
        return $this->srv;
    }

    /**
     * Set costcode
     *
     * @param string $costcode
     * @return Pickupfromlist
     */
    public function setCostcode($costcode)
    {
        $this->costcode = $costcode;

        return $this;
    }

    /**
     * Get costcode
     *
     * @return string 
     */
    public function getCostcode()
    {
        return $this->costcode;
    }

    /**
     * Set instru1
     *
     * @param string $instru1
     * @return Pickupfromlist
     */
    public function setInstru1($instru1)
    {
        $this->instru1 = $instru1;

        return $this;
    }

    /**
     * Get instru1
     *
     * @return string 
     */
    public function getInstru1()
    {
        return $this->instru1;
    }

    /**
     * Set instru2
     *
     * @param string $instru2
     * @return Pickupfromlist
     */
    public function setInstru2($instru2)
    {
        $this->instru2 = $instru2;

        return $this;
    }

    /**
     * Get instru2
     *
     * @return string 
     */
    public function getInstru2()
    {
        return $this->instru2;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Pickupfromlist
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set taxcode
     *
     * @param string $taxcode
     * @return Pickupfromlist
     */
    public function setTaxcode($taxcode)
    {
        $this->taxcode = $taxcode;

        return $this;
    }

    /**
     * Get taxcode
     *
     * @return string 
     */
    public function getTaxcode()
    {
        return $this->taxcode;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Pickupfromlist
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Pickupfromlist
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Pickupfromlist
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Pickupfromlist
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
}
