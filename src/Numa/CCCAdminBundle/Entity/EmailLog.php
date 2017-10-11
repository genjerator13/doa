<?php

namespace Numa\CCCAdminBundle\Entity;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * EmailLog
 */
class EmailLog
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var string
     */
    private $custcode;

    /**
     * @var integer
     */
    private $batch_id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $email_from;

    /**
     * @var string
     */
    private $email_to;

    /**
     * @var string
     */
    private $raw_data;


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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return EmailLog
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set custcode
     *
     * @param string $custcode
     *
     * @return EmailLog
     */
    public function setCustcode($custcode)
    {
        $this->custcode = $custcode;

        return $this;
    }

    /**
     * Get custcode
     *
     * @return string
     */
    public function getCustcode()
    {
        return $this->custcode;
    }

    /**
     * Set batchId
     *
     * @param integer $batchId
     *
     * @return EmailLog
     */
    public function setBatchId($batchId)
    {
        $this->batch_id = $batchId;

        return $this;
    }

    /**
     * Get batchId
     *
     * @return integer
     */
    public function getBatchId()
    {
        return $this->batch_id;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return EmailLog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return EmailLog
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return EmailLog
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailLog
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set emailFrom
     *
     * @param string $emailFrom
     *
     * @return EmailLog
     */
    public function setEmailFrom($emailFrom)
    {
        $this->email_from = $emailFrom;

        return $this;
    }

    /**
     * Get emailFrom
     *
     * @return string
     */
    public function getEmailFrom()
    {
        return $this->email_from;
    }

    /**
     * Set emailTo
     *
     * @param string $emailTo
     *
     * @return EmailLog
     */
    public function setEmailTo($emailTo)
    {
        $this->email_to = $emailTo;

        return $this;
    }

    /**
     * Get emailTo
     *
     * @return string
     */
    public function getEmailTo()
    {
        return $this->email_to;
    }

    /**
     * Set rawData
     *
     * @param string $rawData
     *
     * @return EmailLog
     */
    public function setRawData($rawData)
    {
        $this->raw_data = $rawData;

        return $this;
    }

    /**
     * Get rawData
     *
     * @return string
     */
    public function getRawData()
    {
        return $this->raw_data;
    }

    public function setStartedAtValue(){
        
    }

    public function setEmail(\Swift_Message $message){
        if($message instanceof \Swift_Message)
        {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);
            $jsonContent = $serializer->serialize($message, 'json');
//            dump($message->getBody());
//            dump($message->getSubject());
//            dump(json_encode($message->getFrom()));
//            dump(json_encode($message->getTo()));
//            dump($jsonContent);

            $this->setBody($message->getBody());
            $this->setSubject($message->getSubject());
            $this->setEmailFrom(json_encode($message->getFrom()));
            $this->setEmailTo(json_encode($message->getTo()));
            $this->setBcc(json_encode($message->getBcc()));
            $this->setRawData($jsonContent);
            $this->setDateCreated(new \DateTime() );


        }
    }
    /**
     * @var string
     */
    private $bcc;


    /**
     * Set bcc
     *
     * @param string $bcc
     *
     * @return EmailLog
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * Get bcc
     *
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }
}
