<?php

namespace Numa\CCCAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Customers
 */
class Customers implements UserInterface{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $custcode;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

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
    private $postal;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var integer
     */
    private $duedays;

    /**
     * @var \DateTime
     */
    private $lastpay;

    /**
     * @var \DateTime
     */
    private $lastpur;

    /**
     * @var float
     */
    private $totbalan;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var string
     */
    private $taxcode;

    /**
     * @var float
     */
    private $custsurchargerate;

    /**
     * @var string
     */
    private $note;

    /**
     * @var float
     */
    private $zerodays;

    /**
     * @var float
     */
    private $thirtydays;

    /**
     * @var float
     */
    private $sixtydays;

    /**
     * @var float
     */
    private $ninetydays;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var string
     */
    private $ratelevel;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $cell;

    /**
     * @var string
     */
    private $cityprovpostal;

    /**
     * @var string
     */
    private $addressblock;

    /**
     * @var \DateTime
     */
    private $revised;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $sendmail;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $terminalid;

    /**
     * @var boolean
     */
    private $israteoverride;

    /**
     * @var boolean
     */
    private $ishwyrateoverride;

    /**
     * @var float
     */
    private $custhwysurchargerate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $probills;

    /**
     * Constructor
     */
    public function __construct() {
        $this->probills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function set($fieldname, $value) {
        $fieldname = strtolower($fieldname);
        $this->$fieldname = $value;

        //check if date
        if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
            $this->$fieldname = new \DateTime($value);
        }
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set custcode
     *
     * @param string $custcode
     * @return Customers
     */
    public function setCustcode($custcode) {
        $this->custcode = $custcode;

        return $this;
    }

    /**
     * Get custcode
     *
     * @return string 
     */
    public function getCustcode() {
        return $this->custcode;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Customers
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Customers
     */
    public function setAddress1($address1) {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1() {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Customers
     */
    public function setAddress2($address2) {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2() {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Customers
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set prov
     *
     * @param string $prov
     * @return Customers
     */
    public function setProv($prov) {
        $this->prov = $prov;

        return $this;
    }

    /**
     * Get prov
     *
     * @return string 
     */
    public function getProv() {
        return $this->prov;
    }

    /**
     * Set postal
     *
     * @param string $postal
     * @return Customers
     */
    public function setPostal($postal) {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string 
     */
    public function getPostal() {
        return $this->postal;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Customers
     */
    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Customers
     */
    public function setFax($fax) {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax() {
        return $this->fax;
    }

    /**
     * Set duedays
     *
     * @param integer $duedays
     * @return Customers
     */
    public function setDuedays($duedays) {
        $this->duedays = $duedays;

        return $this;
    }

    /**
     * Get duedays
     *
     * @return integer 
     */
    public function getDuedays() {
        return $this->duedays;
    }

    /**
     * Set lastpay
     *
     * @param \DateTime $lastpay
     * @return Customers
     */
    public function setLastpay($lastpay) {
        $this->lastpay = $lastpay;

        return $this;
    }

    /**
     * Get lastpay
     *
     * @return \DateTime 
     */
    public function getLastpay() {
        return $this->lastpay;
    }

    /**
     * Set lastpur
     *
     * @param \DateTime $lastpur
     * @return Customers
     */
    public function setLastpur($lastpur) {
        $this->lastpur = $lastpur;

        return $this;
    }

    /**
     * Get lastpur
     *
     * @return \DateTime 
     */
    public function getLastpur() {
        return $this->lastpur;
    }

    /**
     * Set totbalan
     *
     * @param float $totbalan
     * @return Customers
     */
    public function setTotbalan($totbalan) {
        $this->totbalan = $totbalan;

        return $this;
    }

    /**
     * Get totbalan
     *
     * @return float 
     */
    public function getTotbalan() {
        return $this->totbalan;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return Customers
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set taxcode
     *
     * @param string $taxcode
     * @return Customers
     */
    public function setTaxcode($taxcode) {
        $this->taxcode = $taxcode;

        return $this;
    }

    /**
     * Get taxcode
     *
     * @return string 
     */
    public function getTaxcode() {
        return $this->taxcode;
    }

    /**
     * Set custsurchargerate
     *
     * @param float $custsurchargerate
     * @return Customers
     */
    public function setCustsurchargerate($custsurchargerate) {
        $this->custsurchargerate = $custsurchargerate;

        return $this;
    }

    /**
     * Get custsurchargerate
     *
     * @return float 
     */
    public function getCustsurchargerate() {
        return $this->custsurchargerate;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Customers
     */
    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set zerodays
     *
     * @param float $zerodays
     * @return Customers
     */
    public function setZerodays($zerodays) {
        $this->zerodays = $zerodays;

        return $this;
    }

    /**
     * Get zerodays
     *
     * @return float 
     */
    public function getZerodays() {
        return $this->zerodays;
    }

    /**
     * Set thirtydays
     *
     * @param float $thirtydays
     * @return Customers
     */
    public function setThirtydays($thirtydays) {
        $this->thirtydays = $thirtydays;

        return $this;
    }

    /**
     * Get thirtydays
     *
     * @return float 
     */
    public function getThirtydays() {
        return $this->thirtydays;
    }

    /**
     * Set sixtydays
     *
     * @param float $sixtydays
     * @return Customers
     */
    public function setSixtydays($sixtydays) {
        $this->sixtydays = $sixtydays;

        return $this;
    }

    /**
     * Get sixtydays
     *
     * @return float 
     */
    public function getSixtydays() {
        return $this->sixtydays;
    }

    /**
     * Set ninetydays
     *
     * @param float $ninetydays
     * @return Customers
     */
    public function setNinetydays($ninetydays) {
        $this->ninetydays = $ninetydays;

        return $this;
    }

    /**
     * Get ninetydays
     *
     * @return float 
     */
    public function getNinetydays() {
        return $this->ninetydays;
    }

    /**
     * Set discount
     *
     * @param float $discount
     * @return Customers
     */
    public function setDiscount($discount) {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float 
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * Set ratelevel
     *
     * @param string $ratelevel
     * @return Customers
     */
    public function setRatelevel($ratelevel) {
        $this->ratelevel = $ratelevel;

        return $this;
    }

    /**
     * Get ratelevel
     *
     * @return string 
     */
    public function getRatelevel() {
        return $this->ratelevel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customers
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Customers
     */
    public function setWebsite($website) {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * Set cell
     *
     * @param string $cell
     * @return Customers
     */
    public function setCell($cell) {
        $this->cell = $cell;

        return $this;
    }

    /**
     * Get cell
     *
     * @return string 
     */
    public function getCell() {
        return $this->cell;
    }

    /**
     * Set cityprovpostal
     *
     * @param string $cityprovpostal
     * @return Customers
     */
    public function setCityprovpostal($cityprovpostal) {
        $this->cityprovpostal = $cityprovpostal;

        return $this;
    }

    /**
     * Get cityprovpostal
     *
     * @return string 
     */
    public function getCityprovpostal() {
        return $this->cityprovpostal;
    }

    /**
     * Set addressblock
     *
     * @param string $addressblock
     * @return Customers
     */
    public function setAddressblock($addressblock) {
        $this->addressblock = $addressblock;

        return $this;
    }

    /**
     * Get addressblock
     *
     * @return string 
     */
    public function getAddressblock() {
        return $this->addressblock;
    }

    /**
     * Set revised
     *
     * @param \DateTime $revised
     * @return Customers
     */
    public function setRevised($revised) {
        $this->revised = $revised;

        return $this;
    }

    /**
     * Get revised
     *
     * @return \DateTime 
     */
    public function getRevised() {
        return $this->revised;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Customers
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set sendmail
     *
     * @param string $sendmail
     * @return Customers
     */
    public function setSendmail($sendmail) {
        $this->sendmail = $sendmail;

        return $this;
    }

    /**
     * Get sendmail
     *
     * @return string 
     */
    public function getSendmail() {
        return $this->sendmail;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Customers
     */
    public function setContact($contact) {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact() {
        return $this->contact;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Customers
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Customers
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set terminalid
     *
     * @param integer $terminalid
     * @return Customers
     */
    public function setTerminalid($terminalid) {
        $this->terminalid = $terminalid;

        return $this;
    }

    /**
     * Get terminalid
     *
     * @return integer 
     */
    public function getTerminalid() {
        return $this->terminalid;
    }

    /**
     * Set israteoverride
     *
     * @param boolean $israteoverride
     * @return Customers
     */
    public function setIsrateoverride($israteoverride) {
        $this->israteoverride = $israteoverride;

        return $this;
    }

    /**
     * Get israteoverride
     *
     * @return boolean 
     */
    public function getIsrateoverride() {
        return $this->israteoverride;
    }

    /**
     * Set ishwyrateoverride
     *
     * @param boolean $ishwyrateoverride
     * @return Customers
     */
    public function setIshwyrateoverride($ishwyrateoverride) {
        $this->ishwyrateoverride = $ishwyrateoverride;

        return $this;
    }

    /**
     * Get ishwyrateoverride
     *
     * @return boolean 
     */
    public function getIshwyrateoverride() {
        return $this->ishwyrateoverride;
    }

    /**
     * Set custhwysurchargerate
     *
     * @param float $custhwysurchargerate
     * @return Customers
     */
    public function setCusthwysurchargerate($custhwysurchargerate) {
        $this->custhwysurchargerate = $custhwysurchargerate;

        return $this;
    }

    /**
     * Get custhwysurchargerate
     *
     * @return float 
     */
    public function getCusthwysurchargerate() {
        return $this->custhwysurchargerate;
    }

    /**
     * Add probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     * @return Customers
     */
    public function addProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills[] = $probills;

        return $this;
    }

    /**
     * Remove probills
     *
     * @param \Numa\CCCAdminBundle\Entity\Probills $probills
     */
    public function removeProbill(\Numa\CCCAdminBundle\Entity\Probills $probills) {
        $this->probills->removeElement($probills);
    }

    /**
     * Get probills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProbills() {
        return $this->probills;
    }

    /**
     * @var boolean
     */
    private $is_admin;

    /**
     * Set is_admin
     *
     * @param boolean $isAdmin
     * @return Customers
     */
    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get is_admin
     *
     * @return boolean 
     */
    public function getIsAdmin() {
        return $this->isAdmin;
    }
    
    public function getRoles()
    {
        
        if($this->getIsAdmin()){
            return array('ROLE_SUPER_ADMIN');
        }
        if($this->getUserGroup()=="OCR"){
            return array('ROLE_OCR');
        }
        return array('ROLE_CUSTOMER');
        
    }
 
    public function getSalt()
    {
        return null;
    }
 
    public function eraseCredentials()
    {
 
    }
 
    public function equals(Customers $user)
    {
        return $user->getUsername() == $this->getUsername();
    }    
    
    public function __toString() {
        
        return $this->getName()."";
    }

    /**
     * @var boolean
     */
    private $isAdmin;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Dispatchcard;


    /**
     * Add Dispatchcard
     *
     * @param \Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard
     * @return Customers
     */
    public function addDispatchcard(\Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard)
    {
        $this->Dispatchcard[] = $dispatchcard;
    
        return $this;
    }

    /**
     * Remove Dispatchcard
     *
     * @param \Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard
     */
    public function removeDispatchcard(\Numa\CCCAdminBundle\Entity\Dispatchcard $dispatchcard)
    {
        $this->Dispatchcard->removeElement($dispatchcard);
    }

    /**
     * Get Dispatchcard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDispatchcard()
    {
        return $this->Dispatchcard;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $CustomerEmails;


    /**
     * Add CustomerEmails
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomerEmails $customerEmails
     * @return Customers
     */
    public function addCustomerEmail(\Numa\CCCAdminBundle\Entity\CustomerEmails $customerEmails)
    {
        $this->CustomerEmails[] = $customerEmails;
    
        return $this;
    }

    /**
     * Remove CustomerEmails
     *
     * @param \Numa\CCCAdminBundle\Entity\CustomerEmails $customerEmails
     */
    public function removeCustomerEmail(\Numa\CCCAdminBundle\Entity\CustomerEmails $customerEmails)
    {
        $this->CustomerEmails->removeElement($customerEmails);
    }

    /**
     * Get CustomerEmails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCustomerEmails()
    {
        return $this->CustomerEmails;
    }
    /**
     * @var string
     */
    private $user_group;


    /**
     * Set userGroup
     *
     * @param string $userGroup
     *
     * @return Customers
     */
    public function setUserGroup($userGroup)
    {
        $this->user_group = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return string
     */
    public function getUserGroup()
    {
        return $this->user_group;
    }


    /**
     * @var string
     */
    private $rate_pdf;


    /**
     * Set ratePdf
     *
     * @param string $ratePdf
     *
     * @return Customers
     */
    public function setRatePdf($ratePdf)
    {
        $this->rate_pdf = $ratePdf;

        return $this;
    }

    /**
     * Get ratePdf
     *
     * @return string
     */
    public function getRatePdf()
    {
        return $this->rate_pdf;
    }
    /**
     * @var string
     */
    private $rate_pdf_file;


    /**
     * Set ratePdfFile
     *
     * @param string $ratePdfFile
     *
     * @return Customers
     */
    public function setRatePdfFile($ratePdfFile)
    {
        $this->rate_pdf_file = $ratePdfFile;

        return $this;
    }

    /**
     * Get ratePdfFile
     *
     * @return string
     */
    public function getRatePdfFile()
    {
        return $this->rate_pdf_file;
    }

    public function getAbsolutePath()
    {
        return null === $this->rate_pdf ? null : $this->getUploadRootDir() . '/' . $this->rate_pdf;
    }

    public function getWebPath()
    {
        //dump($this->rate_pdf);die();
        return null === $this->rate_pdf ? null : $this->getUploadDir() . '/' . $this->rate_pdf;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'upload/customer';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getRatePdfFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir(),0777,true);
        }
        $this->getRatePdfFile()->move(
            $this->getUploadRootDir(), $this->getRatePdfFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->rate_pdf = $this->getRatePdfFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->rate_pdf_file = null;
    }
    /**
     * @var boolean
     */
    private $activate;


    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return Customers
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    public function isDeactivated()
    {
        return !($this->activate===null || $this->activate);
    }
}
