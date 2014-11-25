<?php

namespace Numa\DOAAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemField
 */
class ItemField {

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
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set item_id
     *
     * @param integer $itemId
     * @return ItemField
     */
    public function setItemId($itemId) {
        $this->item_id = $itemId;

        return $this;
    }

    /**
     * Get item_id
     *
     * @return integer 
     */
    public function getItemId() {
        return $this->item_id;
    }

    /**
     * Set field_name
     *
     * @param string $fieldName
     * @return ItemField
     */
    public function setFieldName($fieldName) {
        $this->field_name = $fieldName;

        return $this;
    }

    /**
     * Get field_name
     *
     * @return string 
     */
    public function getFieldName() {
        return $this->field_name;
    }

    /**
     * Set field_type
     *
     * @param string $fieldType
     * @return ItemField
     */
    public function setFieldType($fieldType) {
        $this->field_type = $fieldType;

        return $this;
    }

    /**
     * Get field_type
     *
     * @return string 
     */
    public function getFieldType() {
        return $this->field_type;
    }

    /**
     * Set field_string_value
     *
     * @param string $fieldStringValue
     * @return ItemField
     */
    public function setFieldStringValue($fieldStringValue) {
        $this->field_string_value = $fieldStringValue;

        return $this;
    }

    /**
     * Get field_string_value
     *
     * @return string 
     */
    public function getFieldStringValue() {
        return $this->field_string_value;
    }

    /**
     * Set field_boolean_value
     *
     * @param boolean $fieldBooleanValue
     * @return ItemField
     */
    public function setFieldBooleanValue($fieldBooleanValue) {
        $this->field_boolean_value = $fieldBooleanValue;

        return $this;
    }

    /**
     * Get field_boolean_value
     *
     * @return boolean 
     */
    public function getFieldBooleanValue() {
        return $this->field_boolean_value;
    }

    /**
     * Set field_integer_value
     *
     * @param integer $fieldIntegerValue
     * @return ItemField
     */
    public function setFieldIntegerValue($fieldIntegerValue) {
        $this->field_integer_value = $fieldIntegerValue;

        return $this;
    }

    /**
     * Get field_integer_value
     *
     * @return integer 
     */
    public function getFieldIntegerValue() {
        return $this->field_integer_value;
    }

    /**
     * Set field_datetime_value
     *
     * @param \DateTime $fieldDatetimeValue
     * @return ItemField
     */
    public function setFieldDatetimeValue($fieldDatetimeValue) {
        $this->field_datetime_value = $fieldDatetimeValue;

        return $this;
    }

    /**
     * Get field_datetime_value
     *
     * @return \DateTime 
     */
    public function getFieldDatetimeValue() {
        return $this->field_datetime_value;
    }

    /**
     * Set field_id
     *
     * @param integer $fieldId
     * @return ItemField
     */
    public function setFieldId($fieldId) {
        $this->field_id = $fieldId;

        return $this;
    }

    /**
     * Get field_id
     *
     * @return integer 
     */
    public function getFieldId() {
        return $this->field_id;
    }

    /**
     * Set Listingfield
     *
     * @param \Numa\DOAAdminBundle\Entity\Listingfield $listingfield
     * @return ItemField
     */
    public function setListingfield(\Numa\DOAAdminBundle\Entity\Listingfield $listingfield = null) {
        $this->Listingfield = $listingfield;
        $this->setFieldName($listingfield->getCaption());
        $this->setFieldType($listingfield->getType());
        return $this;
    }

    /**
     * Get Listingfield
     *
     * @return \Numa\DOAAdminBundle\Entity\Listingfield 
     */
    public function getListingfield() {
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
    public function setItem(\Numa\DOAAdminBundle\Entity\Item $item = null) {
        $this->Item = $item;

        return $this;
    }

    /**
     * Get Item
     *
     * @return \Numa\DOAAdminBundle\Entity\Item 
     */
    public function getItem() {
        return $this->Item;
    }

    public function __toString() {
        return $this->getFieldName();
    }

    function setAllValues($value, $valueMapValues = "") {
        $value = (string) $value;
        if (!empty($valueMapValues)) {
            $json = json_decode($valueMapValues, true);
            if (!empty($json)) {
                foreach ($json as $key => $mapValue) {
                    if (strtolower($key) == strtolower($value)) {
                        $value = $mapValue;
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
    public function setSortOrder($sortOrder) {
        $this->sort_order = $sortOrder;

        return $this;
    }

    /**
     * Get sort_order
     *
     * @return integer 
     */
    public function getSortOrder() {
        return $this->sort_order;
    }

    public function handleImage($stringValue, $upload_path, $upload_url, $feed_sid, $order = 0, $localy = false) {

        $url = $stringValue;
        //get etension//

        $filename = pathinfo($url, PATHINFO_BASENAME);
        if ($url instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            $filename = $url->getClientOriginalName();
        }
        $img_url = $url;

        if ((!empty($url) && $localy) || $url instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            //$feed_sid = $this->getItem()->getImportfeed()->getId();
            $dir = $upload_path . "/" . $feed_sid;
            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }
            $filename = strtolower(str_replace(" ", "-", $feed_sid)) . "_" . $filename;

            $filename = str_replace(array(" ", '%'), "-", $filename);

            $img = $dir . "/" . $filename;
            $img_url = $upload_url . "/" . $feed_sid . "/" . $filename;

            

            if ($url instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                echo $dir . ":::" . $filename;

                $file = $url->move($dir, $filename);
            } else if (!file_exists($img)) {
                $http = substr($url, 0, 4) == 'http';
                if ($http) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_NOBODY, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_exec($ch);
                    $is200 = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;
                    curl_close($ch);

                    if ($is200) {
                        //valid 
                        file_put_contents($img, file_get_contents($url));
                    } else {
                        
                    }
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
    public function setFeedId($feedId) {
        $this->feed_id = $feedId;

        return $this;
    }

    /**
     * Get feed_id
     *
     * @return integer 
     */
    public function getFeedId() {
        return $this->feed_id;
    }

}
