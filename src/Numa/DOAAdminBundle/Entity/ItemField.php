<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemField
 */
class ItemField
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $item_id;

    /**
     * @var string
     */
    private $field_name;

    /**
     * @var string
     */
    private $field_type;

    /**
     * @var string
     */
    private $field_string_value;

    /**
     * @var boolean
     */
    private $field_boolean_value;

    /**
     * @var integer
     */
    private $field_integer_value;

    /**
     * @var \DateTime
     */
    private $field_datetime_value;

    /**
     * @var integer
     */
    private $field_id;

    /**
     * @var \Numa\DOAAdminBundle\Entity\Listingfield
     */
    private $Listingfield;


    /**
     * Constructor
     */
    public function __construct()
    {
        //$this->Listingfield = new \Doctrine\Common\Collections\ArrayCollection();

    }

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
     * Set item_id
     *
     * @param integer $itemId
     * @return ItemField
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get item_id
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set field_name
     *
     * @param string $fieldName
     * @return ItemField
     */
    public function setFieldName($fieldName)
    {
        $this->field_name = $fieldName;

        return $this;
    }

    /**
     * Get field_name
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * Set field_type
     *
     * @param string $fieldType
     * @return ItemField
     */
    public function setFieldType($fieldType)
    {
        $this->field_type = $fieldType;

        return $this;
    }

    /**
     * Get field_type
     *
     * @return string
     */
    public function getFieldType()
    {
        return $this->field_type;
    }

    /**
     * Set field_string_value
     *
     * @param string $fieldStringValue
     * @return ItemField
     */
    public function setFieldStringValue($fieldStringValue)
    {
        $this->field_string_value = $fieldStringValue;

        return $this;
    }

    /**
     * Get field_string_value
     *
     * @return string
     */
    public function getFieldStringValue()
    {
        return $this->field_string_value;
    }

    /**
     * Set field_boolean_value
     *
     * @param boolean $fieldBooleanValue
     * @return ItemField
     */
    public function setFieldBooleanValue($fieldBooleanValue)
    {
        $this->field_boolean_value = $fieldBooleanValue;

        return $this;
    }

    /**
     * Get field_boolean_value
     *
     * @return boolean
     */
    public function getFieldBooleanValue()
    {
        return $this->field_boolean_value;
    }

    /**
     * Set field_integer_value
     *
     * @param integer $fieldIntegerValue
     * @return ItemField
     */
    public function setFieldIntegerValue($fieldIntegerValue)
    {
        $this->field_integer_value = $fieldIntegerValue;

        return $this;
    }

    /**
     * Get field_integer_value
     *
     * @return integer
     */
    public function getFieldIntegerValue()
    {
        return $this->field_integer_value;
    }

    /**
     * Set field_datetime_value
     *
     * @param \DateTime $fieldDatetimeValue
     * @return ItemField
     */
    public function setFieldDatetimeValue($fieldDatetimeValue)
    {
        $this->field_datetime_value = $fieldDatetimeValue;

        return $this;
    }

    /**
     * Get field_datetime_value
     *
     * @return \DateTime
     */
    public function getFieldDatetimeValue()
    {
        return $this->field_datetime_value;
    }

    /**
     * Set field_id
     *
     * @param integer $fieldId
     * @return ItemField
     */
    public function setFieldId($fieldId)
    {
        $this->field_id = $fieldId;

        return $this;
    }

    /**
     * Get field_id
     *
     * @return integer
     */
    public function getFieldId()
    {
        return $this->field_id;
    }

    /**
     * Set Listingfield
     *
     * @param \Numa\DOAAdminBundle\Entity\Listingfield $listingfield
     * @return ItemField
     */
    public function setListingfield(\Numa\DOAAdminBundle\Entity\Listingfield $listingfield = null)
    {
        if ($listingfield instanceof ListingField) {
            $this->Listingfield = $listingfield;
        }
        $this->setFieldName($listingfield->getCaption());
        $this->setFieldType($listingfield->getType());
        return $this;
    }

    /**
     * Get Listingfield
     *
     * @return \Numa\DOAAdminBundle\Entity\Listingfield
     */
    public function getListingfield()
    {
        return $this->Listingfield;
    }

    /**
     * @var \Numa\DOAAdminBundle\Entity\Item
     */
    private $Item;

    /**
     * Set Item
     *
     * @param \Numa\DOAAdminBundle\Entity\Item $item
     * @return ItemField
     */
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null)
    {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get Item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->Item;
    }

    public function __toString()
    {
        return $this->getFieldName();
    }

    function setAllValues($value, $valueMapValues = "")
    {

        if (is_array($value)) {
            $value = json_encode($value, true);
        } else {
            $value = (string)trim($value);
        }

        //process mapvalues map values
        if (!empty($valueMapValues)) {
            $json = json_decode($valueMapValues, true);
            if (!empty($json)) {
                foreach ($json as $key => $mapValue) {
                    $key = trim($key);

                    if (strtolower($key) == strtolower($value)) {
                        $value = trim($mapValue);
                    }
                }
            }
        }


        $this->field_string_value = $value;
        $this->field_integer_value = intval($value);
        $this->field_boolean_value = !empty($value);
    }

    /**
     * @var integer
     */
    private $sort_order;

    /**
     * Set sort_order
     *
     * @param integer $sortOrder
     * @return ItemField
     */
    public function setSortOrder($sortOrder)
    {
        $this->sort_order = $sortOrder;

        return $this;
    }

    /**
     * Get sort_order
     *
     * @return integer
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * Downloads image from $stringValue which could be UploadedFile
     * Function accepts p...
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $stringValue or string
     * @param string $upload_path
     * @param string $upload_url
     * @param integer $feed_sid
     * @param integer $order
     * @param boolean $localy
     * @param string $uniqueValue
     */
    public function handleImage($stringValue, $upload_path, $upload_url, $feed_sid, $order = 0, $localy = false, $uniqueValue = "")
    {
        if (is_array($stringValue)) {
            $stringValue = $stringValue['url'];
        }
        $url = $stringValue;
        $filename = pathinfo($url, PATHINFO_BASENAME);
        if ($stringValue instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            $filename = $stringValue->getClientOriginalName();
        } else {
            if (stripos($stringValue, "http") === false) {
                //dump($stringValue);die();
                //$url = trim(str_replace(array("\"", " ", "'"), "", $stringValue));
                //TODO
            }
        }

        $img_url = $url;
        $subfolder = "";
        if ($feed_sid instanceof Importfeed) {
            $subfolder = $feed_sid->getId();
        } elseif (is_string($feed_sid)) {
            $subfolder = $feed_sid;
        }
        if ((!empty($url) && $localy) || $url instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            //make a folder if not exists
            $dir = $upload_path  . $subfolder;

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            //prepare filename for the image
            $filename = $subfolder . "_" . $uniqueValue . "_" . $filename;
            $filename = str_replace(array(" ", '%'), "-", $filename);

            //chek if filename has extension

            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            //full path to the uploaded image
            $img = $dir . "/" . $filename;
            $img_url = $upload_url . "/" . $subfolder . "/" . $filename;

            if ($url instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                // move the file to upload folder
                $file = $url->move($dir, $filename);
            } elseif ((!empty($url) && $localy) && is_string($feed_sid)) {
                copy($stringValue, $img);
            } else if (!file_exists($img)) {

                //check if image starts with http
                $http = substr($url, 0, 4) == 'http';

                if ($http) {
                    //get image via curl
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    //curl_setopt($ch, CURLOPT_NOBODY, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $username = $feed_sid->getUsername();
                    $password = $feed_sid->getPassword();

                    if (!empty($username) && !empty($password)) {
                        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    }
                    $return = curl_exec($ch);

                    $is200 = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;
                    if ($is200) {
                        //valid 
                        if (empty($ext)) {
                            $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                            switch ($content_type) {
                                case "image/jpeg":
                                    $ext = "jpg";
                                    break;
                                case "image/gif":
                                    $ext = "gif";
                                    break;
                                case "image/png":
                                    $ext = "png";
                                    break;
                                default:
                                    break;
                            }
                            $img = $img . "." . $ext;
                            $img_url = $img_url . "." . $ext;
                        }
                        file_put_contents($img, $return);
                    } else {

                    }

                    curl_close($ch);
                }
            }
        }

        $this->setFieldName('Image List');
        $this->setFieldType('Array');
        $this->setAllValues($img_url);
        $this->setSortOrder($order);
    }

    /**
     * @var integer
     */
    private $feed_id;

    /**
     * Set feed_id
     *
     * @param integer $feedId
     * @return ItemField
     */
    public function setFeedId($feedId)
    {
        $this->feed_id = $feedId;

        return $this;
    }

    /**
     * Get feed_id
     *
     * @return integer
     */
    public function getFeedId()
    {
        return $this->feed_id;
    }

    /**
     * @var double
     */
    private $field_double_value;

    /**
     * Set field_double_value
     *
     * @param \double $fieldDoubleValue
     * @return ItemField
     */
    public function setFieldDoubleValue($fieldDoubleValue)
    {
        $this->field_double_value = $fieldDoubleValue;

        return $this;
    }

    /**
     * Get field_double_value
     *
     * @return double
     */
    public function getFieldDoubleValue()
    {
        return $this->field_double_value;
    }

}
