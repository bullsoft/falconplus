<?php
namespace BullSoft\Cart;

class Shipment 
{

    /**
     * @var string|int
     */
    protected $_id;

    /**
     * @var bool
     */
    protected $_isTaxable;

    /**
     * @var bool
     */
    protected $_isDiscountable;

    /**
     * @var array of Item
     */
    protected $_items;

    /**
     * @var float
     */
    protected $_price;

    /**
     * @var float
     */
    protected $_weight;

    /**
     * @var string|int
     */
    protected $_method;

    /**
     * @var string|int
     */
    protected $_vendor;

    static $prefix = 'shipment-'; // array key prefix

    /**
     * Get key for associative arrays
     */
    static function getKey($id)
    {
        return self::$prefix . $id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Enable casting as string for this class
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Serialize toArray() as json string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Export as array
     */
    public function toArray()
    {
        return array(
            'id'              => $this->getId(),
            'method'          => $this->getMethod(),
            'vendor'          => $this->getVendor(),
            'code'            => $this->getCode(),
            'price'           => $this->getPrice(),
            'is_taxable'      => $this->getIsTaxable(),
            'is_discountable' => $this->getIsDiscountable(),
        );
    }

    /**
     * Import object from json
     */
    public function importJson($json, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        $data = @ (array) json_decode($json, true);

        $id = isset($data['id']) ? $data['id'] : '';
        $price = isset($data['price']) ? $data['price'] : 0;
        $isTaxable = isset($data['is_taxable']) ? $data['is_taxable'] : false;
        $isDiscountable = isset($data['is_discountable']) ? $data['is_discountable'] : false;
        $method = isset($data['method']) ? $data['method'] : '';
        $vendor = isset($data['vendor']) ? $data['vendor'] : '';

        $this->_id = $id;
        $this->_price = $price;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        $this->_method = $method;
        $this->_vendor = $vendor;

        return $this;
    }

    /**
     * Import from a stdClass object
     */
    public function importStdClass($obj)
    {
        $id = isset($obj->id) ? $obj->id : '';
        $price = (float) isset($obj->price) ? $obj->price : 0;
        $isTaxable = (bool) isset($obj->is_taxable) ? $obj->is_taxable : false;
        $isDiscountable = (bool) isset($obj->is_discountable) ? $obj->is_discountable : false;
        $vendor = isset($obj->vendor) ? $obj->vendor : '';
        $method = isset($obj->method) ? $obj->method : '';

        $this->_id = $id;
        $this->_price = $price;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        $this->_method = $method;
        $this->_vendor = $vendor;

        return $this;
    }

    /**
     * Reset to defaults
     */
    public function reset()
    {
        $this->_id = '';
        $this->_price = 0;
        $this->_isTaxable = false;
        $this->_isDiscountable = true;
        $this->_method = '';
        $this->_vendor = '';

        return $this;
    }

    /**
     * Check whether this shipment validates a discount condition
     *
     * @param DiscountCondition
     * @return bool
     */
    public function isValidCondition(DiscountCondition $condition)
    {
        switch($condition->getSourceEntityField()) {
            case 'code':
                $condition->setSourceValue($this->getCode());
                break;
            case 'price':
                $condition->setSourceValue($this->getPrice());
                break;
            default:
                //no-op
                break;
        }

        return $condition->isValid();
    }

    /**
     * Check whether this shipment validates a hierarchy of discount conditions
     *
     * @param DiscountConditionCompare
     * @return bool
     */
    public function isValidConditionCompare(DiscountConditionCompare $compare)
    {
        return $compare->isValid($this);
    }

    /**
     * Getter for shipment Id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set shipment Id
     *
     * @param int
     * @return Shipment
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Retrieve a vendor/method code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getVendor() . '_' . $this->getMethod();
    }

    /**
     * Getter for price
     *
     * @return string|float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Setter for the price
     *
     * @param string|float
     * @return Shipment
     */
    public function setPrice($price)
    {
        $this->_price = $price;
        return $this;
    }

    /**
     * Check whether this shipment is taxable
     *
     * @return bool
     */
    public function getIsTaxable()
    {
        return $this->_isTaxable;
    }

    /**
     * Set whether this shipment is taxable
     *
     * @param bool
     * @return Shipment
     */
    public function setIsTaxable($isTaxable)
    {
        $this->_isTaxable = $isTaxable;
        return $this;
    }

    /**
     * Check whether this shipment is discountable
     *
     * @return bool
     */
    public function getIsDiscountable()
    {
        return $this->_isDiscountable;
    }

    /**
     * Set whether this shipment is discountable
     *
     * @param bool
     * @return Shipment
     */
    public function setIsDiscountable($isDiscountable)
    {
        $this->_isDiscountable = $isDiscountable;
        return $this;
    }

    /**
     * Get the method eg Ground, 2-Day, 3-Day
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * Set the method
     *
     * @param scalar
     * @return Shipment
     */
    public function setMethod($method)
    {
        $this->_method = $method;
        return $this;
    }

    /**
     * Get the vendor of this shipment
     *
     * @return scalar
     */
    public function getVendor()
    {
        return $this->_vendor;
    }

    /**
     * Set the vendor of this shipment
     *
     * @param scalar
     * @return Shipment
     */
    public function setVendor($vendor)
    {
        $this->_vendor = $vendor;
        return $this;
    }

}
