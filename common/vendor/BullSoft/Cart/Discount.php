<?php
namespace BullSoft\Cart;

class Discount 
{
    /**
     * @var string|int
     */
    protected $_id; // Your Discount/Rule Id

    /**
     * @var DiscountConditionCompare
     */
    protected $_preConditionCompare;

    /**
     * @var DiscountConditionCompare
     */
    protected $_targetConditionCompare;

    /*
    [compare-1] => array(
        //compare object
        [op] => and,
        [conditions] => array(
            [0] => array(
                //compare object
                [op] => and,
                [left] => condition-1, //condition object
                [right] => condition-2, //condition object
                [conditions] => array(), //empty since we're doing left/right
            ),
            [1] => array(
                //compare object
                [op] => or,
                [left] => condition-3, //condition object
                [right] => array(
                    //compare object
                    [op] => or,
                    [left] => condition-4, //condition object
                    [right] => condition-5, //condition object
                    [conditions] => array(), //empty since we're doing left/right
                )
            ),
        ),
        [left] => null, //empty since we're doing array
        [right] => null, //empty since we're doing array
    )
    */

    /**
     * @var string
     */
    protected $_as; // percent|flat

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var int|string
     */
    protected $_startDatetime;

    /**
     * @var int|string
     */
    protected $_endDatetime;

    /**
     * @var int
     */
    protected $_priority; // YOUR Discount/Rule priority

    /**
     * @var float|string
     */
    protected $_value; // eg 2.50 is a flat discount, 0.25 is 25% off, 
    
    /**
     * @var bool
     */
    protected $_isCompound;
    
    /**
     * @var bool
     */
    protected $_isProportional;

    /**
     * @var float|string
     */
    protected $_maxAmount;

    /**
     * @var float|int|string
     */
    protected $_maxQty;
    
    /**
     * @var bool
     */
    protected $_isMaxPerItem;

    /**
     * @var string
     */
    protected $_to; // products|shipping|specified

    /**
     * @var array of Item, key => quantity
     */
    protected $_items;

    /**
     * @var array of Shipment, key => key
     */
    protected $_shipments;

    /**
     * @var bool
     */
    protected $_isPreTax; // either before or after tax

    /**
     * @var bool
     */
    protected $_isAuto; // system will try to apply it automatically

    /**
     * @var bool
     */
    protected $_isStopper;

    /**
     * @var string
     */
    protected $_couponCode; // should already be validated

    // array key values
    static $defaultPriority = 1000;
    static $asFlat = 'flat';
    static $asPercent = 'percent';
    static $toSpecified = 'specified';
    static $toShipments = 'shipments';
    static $toItems = 'items';
    static $prefix = 'discount-'; // array key prefix

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Get a prefixed key for associative arrays
     *
     * @param int
     * @return string
     */
    static function getKey($id)
    {
        return self::$prefix . $id;
    }

    /**
     * Enable string casting for this class
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Serialize toArray() as json string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Export as array
     *
     * @return array
     */
    public function toArray()
    {
        $preConditionCompareData = null;
        if (is_object($this->getPreConditionCompare())) {
            $preConditionCompareData = $this->getPreConditionCompare()->toArray();
        }

        $targetConditionCompareData = null;
        if (is_object($this->getTargetConditionCompare())) {
            $targetConditionCompareData = $this->getTargetConditionCompare()->toArray();
        }

        return array(
            'id'                => $this->getId(),
            'name'              => $this->getName(),
            'value'             => $this->getValue(),
            'max_qty'           => $this->getMaxQty(),
            'max_amount'        => $this->getMaxAmount(),
            'is_max_per_item'   => $this->getIsMaxPerItem(),
            'as'                => $this->getAs(),
            'to'                => $this->getTo(),
            'is_compound'       => $this->getIsCompound(),
            'is_proportional'   => $this->getIsProportional(),
            'is_pre_tax'        => $this->getIsPreTax(),
            'is_auto'           => $this->getIsAuto(),
            'coupon_code'       => $this->getCouponCode(),
            'items'             => $this->getItems(),
            'shipments'         => $this->getShipments(),
            'is_stopper'        => $this->getIsStopper(),
            'priority'          => $this->getPriority(),
            'start_datetime'    => $this->getStartDatetime(),
            'end_datetime'      => $this->getEndDatetime(),
            'pre_conditions'    => $preConditionCompareData,
            'target_conditions' => $targetConditionCompareData,
        );
    }

    /**
     * Import from json
     *
     * @param string JSON
     * @param bool
     * @return Discount
     */
    public function importJson($json, $reset = true)
    {
        $data = @ (array) json_decode($json);

        if ($reset) {
            $this->reset();
        }

        $id = isset($data['id']) ? $data['id'] : '';
        $name = isset($data['name']) ? $data['name'] : '';

        $as = isset($data['as']) ? $data['as'] : '';
        $as = ($as == self::$asFlat) ? self::$asFlat : self::$asPercent;

        $to = isset($data['to']) ? $data['to'] : '';
        if (!in_array($to, array(self::$toSpecified, self::$toItems, self::$toShipments))) {
            $to = self::$toItems;
        }

        $value = isset($data['value']) ? $data['value'] : 0;
        $isPreTax = isset($data['is_pre_tax']) ? $data['is_pre_tax'] : false;
        $isCompound = isset($data['is_compound']) ? $data['is_compound'] : false;
        $isProportional = isset($data['is_proportional']) ? $data['is_proportional'] : false;

        $startDatetime = ''; //TODO
        $endDatetime = ''; //TODO

        $maxQty = isset($data['max_qty']) ? $data['max_qty'] : 0;
        $maxAmount = isset($data['max_qty']) ? $data['max_qty'] : 0;
        $isMaxPerItem = isset($data['is_max_per_item']) ? $data['is_max_per_item'] : false;

        $toItems = isset($data['items']) ? $data['items'] : array();
        $toShipments = isset($data['shipments']) ? $data['shipments'] : array();

        $shipments = array();
        $items = array();
        
        if (count($toItems) > 0) {
            foreach($toItems as $key) {
                $items[] = $key;
            }
        }

        if (count($toShipments) > 0) {
            foreach($toShipments as $key) {
                $shipments[] = $key;
            }
        }

        $preConditionObj = isset($data['pre_conditions']) ? $data['pre_conditions'] : null;
        $targetConditionObj = isset($data['target_conditions']) ? $data['target_conditions'] : null;

        $preCondition = null;
        if (!is_null($preConditionObj)) {
            $preCondition = new DiscountConditionCompare();
            $preCondition->importJson(json_encode($preConditionObj));
        }
        
        $targetCondition = null;
        if (!is_null($targetConditionObj)) {
            $targetCondition = new DiscountConditionCompare();
            $targetCondition->importJson(json_encode($targetConditionObj));
        }
            
        $couponCode = isset($data['coupon_code']) ? $data['coupon_code'] : '';
        $isAuto = isset($data['is_auto']) ? $data['is_auto'] : false;

        $isStopper = (bool) isset($data['is_stopper']) ? $data['is_stopper'] : false;
        $priority = isset($data['priority']) ? $data['priority'] : self::$defaultPriority;

        $this->_id = $id;
        $this->_name = $name;
        $this->_as = $as;
        $this->_to = $to;
        $this->_value = $value;
        $this->_maxQty = $maxQty;
        $this->_maxAmount = $maxAmount;
        $this->_isMaxPerItem = $isMaxPerItem;
        $this->_isCompound = $isCompound;
        $this->_isProportional = $isProportional;
        $this->_isPreTax = $isPreTax;
        $this->_isAuto = $isAuto;
        $this->_isStopper = $isStopper;
        $this->_priority = $priority;
        $this->_couponCode = $couponCode;
        $this->_startDatetime = $startDatetime;
        $this->_endDatetime = $endDatetime;
        $this->_items = $items;
        $this->_shipments = $shipments;
        $this->_targetConditionCompare = $targetCondition;
        $this->_preConditionCompare = $preCondition;

        return $this;
    }

    /**
     * Import from stdClass
     *
     * @param stdClass
     * @param bool
     * @return Discount
     */
    public function importStdClass($obj, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        $id = isset($obj->id) ? $obj->id : '';
        $key = ($id > 0) ? self::getKey($id) : '';
        $name = isset($obj->name) ? $obj->name : '';

        $as = isset($obj->as) ? $obj->as : '';
        $as = ($as == self::$asFlat) ? self::$asFlat : self::$asPercent;

        $to = isset($obj->to) ? $obj->to : '';
        if (!in_array($to, array(self::$toSpecified, self::$toItems, self::$toShipments))) {
            $to = self::$toItems;
        }

        $value = isset($obj->value) ? $obj->value : 0;
        $isCompound = isset($obj->is_compound) ? $obj->is_compound : false;
        $isProportional = isset($obj->is_proportional) ? $obj->is_proportional : false;
        $isPreTax = isset($obj->is_pre_tax) ? $obj->is_pre_tax : false;
        $toItems = isset($obj->items) ? $obj->items : array();
        $toShipments = isset($obj->shipments) ? $obj->shipments : array();
        $shipments = array();
        $items = array();
        
        if (count($toItems) > 0) {
            foreach($toItems as $key) {
                $items[] = $key;
            }
        }

        if (count($toShipments) > 0) {
            foreach($toShipments as $key) {
                $shipments[] = $key;
            }
        }

        $preConditionObj = isset($obj->pre_conditions) ? $obj->pre_conditions : new stdClass();
        $targetConditionObj = isset($obj->target_conditions) ? $obj->target_conditions : new stdClass();

        $preCondition = null;
        if ($preConditionObj instanceof stdClass) {
            $preCondition = new DiscountConditionCompare();
            $preCondition->importStdClass($preConditionObj);
        } else if (is_array($preConditionObj)) {
            $preCondition = new DiscountConditionCompare();
            $preCondition->importJson(json_encode($preConditionObj));
        }

        $targetCondition = null;
        if ($targetConditionObj instanceof stdClass) {
            $targetCondition = new DiscountConditionCompare();
            $targetCondition->importStdClass($targetConditionObj);
        } else if (is_array($targetConditionObj)) {
            $targetCondition = new DiscountConditionCompare();
            $targetCondition->importJson(json_encode($targetConditionObj));
        }

        $couponCode = isset($obj->coupon_code) ? $obj->coupon_code : '';
        $isAuto = isset($obj->is_auto) ? $obj->is_auto : false;
        $isStopper = (bool) isset($obj->is_stopper) ? $obj->is_stopper : false;
        $priority = isset($obj->priority) ? $obj->priority : 0;

        $startDatetime = ''; //TODO
        $endDatetime = ''; //TODO

        $maxQty = isset($obj->max_qty) ? $obj->max_qty : 0;
        $maxAmount = isset($obj->max_amount) ? $obj->max_amount : 0;
        $isMaxPerItem = isset($obj->is_max_per_item) ? $obj->is_max_per_item : false;

        $this->_id = $id;
        $this->_name = $name;
        $this->_as = $as;
        $this->_to = $to;
        $this->_value = $value;
        $this->_maxQty = $maxQty;
        $this->_maxAmount = $maxAmount;
        $this->_isCompound = $isCompound;
        $this->_isProportional = $isProportional;
        $this->_isMaxPerItem = $isMaxPerItem;
        $this->_isPreTax = $isPreTax;
        $this->_isAuto = $isAuto;
        $this->_isStopper = $isStopper;
        $this->_priority = $priority;
        $this->_startDatetime = $startDatetime;
        $this->_endDatetime = $endDatetime;
        $this->_couponCode = $couponCode;
        $this->_items = $items;
        $this->_shipments = $shipments;
        $this->_targetConditionCompare = $preCondition;
        $this->_preConditionCompare = $targetCondition;

        return $this;
    }

    /**
     * Import from an entity
     *
     * @param mixed|object
     * @return Discount
     */
    public function importEntity($entity)
    {
        $id = $entity->getId();
        $name = $entity->getName();
        $as = $entity->getAs();
        $to = $entity->getTo();
        $value = $entity->getValue();
        $isCompound = $entity->getIsCompound();
        $isPreTax = $entity->getIsPreTax();
        $isAuto = $entity->getIsAuto();
        $isStopper = $entity->getIsStopper();
        $priority = $entity->getPriority();
        $couponCode = $entity->getCouponCode();

        $startDatetime = strtotime($entity->getStartDatetime());
        $endDatetime = strtotime($entity->getEndDatetime());

        $maxQty = $entity->getMaxQty();
        $maxAmount = $entity->getMaxAmount();
        $isMaxPerItem = $entity->getIsMaxPerItem();

        $toItems = array(); // won't know this until we validate conditions
        $toShipments = array(); // won't know this until we validate conditions

        $this->_id = $id;
        $this->_name = $name;
        $this->_as = $as;
        $this->_to = $to;
        $this->_value = $value;
        $this->_maxQty = $maxQty;
        $this->_maxAmount = $maxAmount;
        $this->_isMaxPerItem = $isMaxPerItem;
        $this->_isCompound = $isCompound;
        $this->_isProportional = $isProportional;
        $this->_isPreTax = $isPreTax;
        $this->_isAuto = $isAuto;
        $this->_isStopper = $isStopper;
        $this->_priority = $priority;
        $this->_couponCode = $couponCode;
        $this->_items = $toItems;
        $this->_shipments = $toShipments;
        $this->_startDatetime = $startDatetime;
        $this->_endDatetime = $endDatetime;
        
        $preCondition = new DiscountConditionCompare();
        $preCondition->importEntity($entity->getPreconditions());
        
        $targetCondition = new DiscountConditionCompare();
        $targetCondition->importEntity($entity->getTargetConditions());

        $this->_preConditionCompare = $preCondition;
        $this->_targetConditionCompare = $targetCondition;

        return $this;
    }

    /**
     * Reset this object to defaults
     *
     * @return Discount
     */
    public function reset()
    {
        $this->_id = 0;
        $this->_name = '';
        $this->_as = self::$asFlat;
        $this->_to = self::$toItems;
        $this->_value = 0;
        $this->_maxQty = 0;
        $this->_maxAmount = 0;
        $this->_isMaxPerItem = false;
        $this->_isCompound = false;
        $this->_isProportional = false;
        $this->_isPreTax = false;
        $this->_isAuto = false;
        $this->_couponCode = '';
        $this->_items = array();
        $this->_shipments = array();
        $this->_isStopper = false;
        $this->_priority = self::$defaultPriority;
        $this->_startDatetime = '';
        $this->_endDatetime = '';
        $this->_preConditionCompare = null;
        $this->_targetConditionCompare = null;

        return $this;
    }
    
    /**
     * Retrieve whether this discount is flat
     *
     * @return bool
     */
    public function isFlat()
    {
        return ($this->getAs() == self::$asFlat);
    }
    
    /**
     * Retrieve whether this discount is a percentage
     *
     * @return bool
     */
    public function isPercent()
    {
        return ($this->getAs() == self::$asPercent);
    }
    
    /**
     * Retrieve whether this discount applies to items
     */
    public function isToItems()
    {
        return ($this->getTo() == self::$toItems);
    }
    
    /**
     * Retrieve whether this discount applies to shipments
     */
    public function isToShipments()
    {
        return ($this->getTo() == self::$toShipments);
    }
    
    /**
     * Retrieve whether this discount applies to specific items,shipments
     */
    public function isToSpecified()
    {
        return ($this->getTo() == self::$toSpecified);
    }

    /**
     * Get the discount Id
     *
     * @return scalar
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set your discount Id
     *
     * @param scalar
     * @return Discount
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Get the name of this discount
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the name of this discount
     *
     * @param string
     * @return Discount
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Get the pre-condition discount condition hierarchy
     *
     * @return DiscountConditionCompare
     */
    public function getPreConditionCompare()
    {
        return $this->_preConditionCompare;
    }

    /**
     * Set the pre-condition discount condition hierarchy
     *
     * @param DiscountConditionCompare
     * @return Discount
     */
    public function setPreConditionCompare(DiscountConditionCompare $compare)
    {
        $this->_preConditionCompare = $compare;
        return $this;
    }

    /**
     * Get the target discount condition hierarchy
     *
     * @return DiscountConditionCompare
     */
    public function getTargetConditionCompare()
    {
        return $this->_targetConditionCompare;
    }

    /**
     * Set the target discount condition hierarchy
     *
     * @param DiscountConditionCompare
     * @return Discount
     */
    public function setTargetConditionCompare(DiscountConditionCompare $compare)
    {
        $this->_targetConditionCompare = $compare;
        return $this;
    }

    /**
     * Getter for whether this discount is flat or percentage
     *
     * @return string
     */
    public function getAs()
    {
        return $this->_as;
    }

    /**
     * Set whether this discount is flat or percentage
     *
     * @param string
     * @return Discount
     */
    public function setAs($as)
    {
        $this->_as = $as;
        return $this;
    }

    /**
     * Get the flat/percentage value set
     *
     * @return string|float
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * Set the flat/percentage value
     *
     * @param string|float
     * @return Discount
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }

    /**
     * Get the max quantity 
     *
     * @return string|float|int
     */
    public function getMaxQty()
    {
        return $this->_maxQty;
    }

    /**
     * Set the max quantity
     *
     * @param string|float|int
     * @return Discount
     */
    public function setMaxQty($maxQty)
    {
        $this->_maxQty = $maxQty;
        return $this;
    }

    /**
     * Get the max amount
     *
     * @return string|float|int
     */
    public function getMaxAmount()
    {
        return $this->_maxAmount;
    }

    /**
     * Set the max amount
     *
     * @param string|float|int
     * @return Discount
     */
    public function setMaxAmount($maxAmount)
    {
        $this->_maxAmount = $maxAmount;
        return $this;
    }

    /**
     * Getter for where this discount is applied to
     *
     * @return string eg 'items','shipments','specified'
     */
    public function getTo()
    {
        return $this->_to;
    }

    /**
     * Set where this discount applies to
     *
     * @param string
     * @return Discount
     */
    public function setTo($to)
    {
        $this->_to = $to;
        return $this;
    }
    
    /**
     * Retrieve whether this discount is applied to the discounted amount
     *
     * @return bool
     */
    public function getIsCompound()
    {
        return $this->_isCompound;
    }

    /**
     * Set whether this discount is applied to the discounted amount
     *
     * @param bool
     * @return Discount
     */
    public function setIsCompound($isCompound)
    {
        $this->_isCompound = $isCompound;
        return $this;
    }
    
    /**
     * Retrieve whether this discount is divided
     *  either by sum of quantity, of applicable items
     *  or if a max quantity is set, and isMaxPerItem is false
     *
     * @return bool
     */
    public function getIsProportional()
    {
        return $this->_isProportional;
    }

    /**
     * Set whether this discount is divided
     *
     * @param bool
     * @return Discount
     */
    public function setIsProportional($isProportional)
    {
        $this->_isProportional = $isProportional;
        return $this;
    }

    /**
     * Retrieve whether this discount can reduce the taxable amount of the cart
     *
     * @return bool
     */
    public function getIsPreTax()
    {
        return $this->_isPreTax;
    }

    /**
     * Set whether this discount can reduce the taxable amount of the cart
     *
     * @param bool
     * @return Discount
     */
    public function setIsPreTax($beforeTax)
    {
        $this->_isPreTax = $beforeTax;
        return $this;
    }

    /**
     * Retrieve whether this discount is automatically checked/applied
     *
     * @return bool
     */
    public function getIsAuto()
    {
        return $this->_isAuto;
    }

    /**
     * Set whether this discount is automatically checked/applied
     *
     * @param bool
     * @return Discount
     */
    public function setIsAuto($isAuto)
    {
        $this->_isAuto = $isAuto;
        return $this;
    }

    /**
     * Retrieve coupon code, if there is one
     *
     * @return string
     */
    public function getCouponCode()
    {
        return $this->_couponCode;
    }

    /**
     * Set coupon code on this discount, empty string means no coupon code
     *
     * @param string
     * @return Discount
     */
    public function setCouponCode($couponCode)
    {
        $this->_couponCode = $couponCode;
        return $this;
    }

    /**
     * Get start of time range, if there is one
     *
     * @return string|int
     */
    public function getStartDatetime()
    {
        return $this->_startDatetime;
    }

    /**
     * Set start of time range
     *
     * @param string|int
     * @return Discount
     */
    public function setStartDatetime($time)
    {
        $this->_startDatetime = $time;
        return $this;
    }

    /**
     * Get end of time range, if there is one
     *
     * @return string|int
     */
    public function getEndDatetime()
    {
        return $this->_endDatetime;
    }

    /**
     * Set end of time range
     *
     * @param string|int
     * @return Discount
     */
    public function setEndDatetime($time)
    {
        $this->_endDatetime = $time;
        return $this;
    }

    // DEV NOTE:
    // Items and Shipments are only for specified discounts
    // set $this->_to = self::$toSpecified

    /**
     * Get specified items, if there are any
     *
     * @return array of Items
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Add an Item to this Discount
     *
     * @param Item $item
     * @param int $qty
     * @return Discount
     */
    public function setItem(Item $item)
    {
        $key = Item::getKey($item->getId());
        if (!in_array($key, $this->getItems())) {
            $this->_items[] = $key;
        }
        return $this;
    }

    /**
     * Remove an Item from this Discount
     *
     * @param string
     * @return Discount
     */
    public function unsetItem($key)
    {
        if ($key instanceof Item) {
            $key = Item::getKey($key->getId());
        }
        
        if (!count($this->getItems())) {
            return $this;
        }
        
        $newItems = array_flip($this->getItems());
        unset($newItems[$key]);
        $newItems = array_flip($newItems);
        $this->_items = $newItems;
        
        return $this;
    }

    /**
     * Assert item is specified in this discount
     *
     * @param string itemKey
     * @return boolean hasItem
     */
    public function hasItem($key)
    {
        return in_array($key, $this->getItems());
    }

    /**
     * Whether this discount has specified items
     *
     * @return bool
     */
    public function hasItems()
    {
        return (count($this->getItems()) > 0);
    }

    /**
     * Getter for specified shipments
     *
     * @return array
     */
    public function getShipments()
    {
        return $this->_shipments;
    }

    /**
     * Add a specified Shipment to this Discount
     *
     * @param Shipment
     * @return Discount
     */
    public function setShipment(Shipment $shipment)
    {
        $key = Shipment::getKey($shipment->getId());
        if (!in_array($key, $this->getShipments())) {
            $this->_shipments[] = $key;
        }
        return $this;
    }

    /**
     * Remove a specified Shipment from this Discount
     *
     * @param string
     * @return Discount
     */
    public function unsetShipment($key)
    {
        if ($key instanceof Shipment) {
            $key = Shipment::getKey($key->getId());
        }
        
        if (!count($this->getShipments())) {
            return $this;
        }
        
        $newShipments = array_flip($this->getShipments());
        unset($newShipments[$key]);
        $newShipments = array_flip($newShipments);
        $this->_shipments = $newShipments;   
        return $this;
    }

    /**
     * Assert shipment is specified in this discount
     *
     * @param string
     * @return bool
     */
    public function hasShipment($key)
    {
        return in_array($key, $this->getShipments());
    }

    /**
     * Assert this discounts has specified shipments
     *
     * @return bool
     */
    public function hasShipments()
    {
        return (count($this->getShipments()) > 0);
    }

    /**
     * Check whether this discount can stop other discounts from applying
     *
     * @return bool
     */
    public function getIsStopper()
    {
        return $this->_isStopper;
    }

    /**
     * Set whether this discount can stop other discounts from applying
     *
     * @param bool
     * @return Discount
     */
    public function setIsStopper($isStopper)
    {
        $this->_isStopper = (bool) $isStopper;
        return $this;
    }

    /**
     * Get the numerical priority of this discount
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->_priority;
    }

    /**
     * Set the numerical priority of this discount
     *
     * @param int
     * @return Discount
     */
    public function setPriority($priority)
    {
        $this->_priority = $priority;
        return $this;
    }
    
    /**
     * Check whether the max values, if set, apply to each item
     *
     * @return bool
     */
    public function getIsMaxPerItem()
    {
        return $this->_isMaxPerItem;
    }

    /**
     * Set whether 
     *
     * @param bool
     * @return Discount
     */
    public function setIsMaxPerItem($isMaxPerItem)
    {
        $this->_isStopper = (bool) $isMaxPerItem;
        return $this;
    }

}