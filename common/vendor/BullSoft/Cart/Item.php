<?php
namespace BullSoft\Cart;

class Item 
{
    /**
     * @var string|int
     */
    protected $_id; // YOUR product Id

    /**
     * @var string
     */
    protected $_sku;

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var float
     */
    protected $_price;
    
    /**
     * @var int|float
     */
    protected $_qty;

    /**
     * @var int|float
     */
    protected $_weight;

    /**
     * @var string
     */
    protected $_categoryIdsCsv;

    /**
     * @var bool
     */
    protected $_isTaxable;

    /**
     * @var bool
     */
    protected $_isDiscountable;
    
    /**
     * @var array
     */
    protected $_custom; // for personalizing items in cart

    /**
     * @var int
     */
    protected $_provider;

    /**
     * @var array
     */
    protected $_vars; // your other product vars . should all be scalar
    
    static $prefix = 'item-';

    /**
     * Get key for associative arrays
     */
    static function getKey($itemId)
    {
        return self::$prefix . $itemId;
    }
    
    /**
     * Constructor
     *
     */
    public function __construct() 
    {
        $this->reset();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Encapsulate object as formatted json string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Encapsulate object as formatted array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'id'              => $this->getId(),
            'sku'             => $this->getSku(),
            'name'            => $this->getName(),
            'price'           => $this->getPrice(),
            'qty'             => $this->getQty(),
            'provider'        => $this->getProvider(),
            'is_taxable'      => $this->getIsTaxable(),
            'is_discountable' => $this->getIsDiscountable(),
            'custom'          => $this->getCustom(),
            'vars'            => $this->getVars(),
        );
        return $data;
    }
        
    /**
     * Import object from json string
     *
     * @param string $json
     * @return Item
     */
    public function importJson($json, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        //automatically resets object
        $data = @ (array) json_decode($json, true);
        if (!isset($data['id']) || !isset($data['qty'])) {
            return false;
        }

        $id = isset($data['id']) ? $data['id'] : '';
        $sku = isset($data['sku']) ? $data['sku'] : '';
        $name = isset($data['name']) ? $data['name'] : '';
        $price = isset($data['price']) ? $data['price'] : 0;
        $qty = isset($data['qty']) ? $data['qty'] : 0;
        $provider = isset($data['provider']) ? $data['provider'] : 0;
        $custom = isset($data['custom']) ? $data['custom'] : array();
        $vars = isset($data['vars']) ? $data['vars'] : array();
        $isTaxable = isset($data['is_taxable']) ? $data['is_taxable'] : false;
        $isDiscountable = isset($data['is_discountable']) ? $data['is_discountable'] : true;
        
        $this->_id = $id;
        $this->_sku = $sku;
        $this->_name = $name;
        $this->_price = $price;
        $this->_qty = $qty;
        $this->_provider = $provider;
        $this->_custom = $custom;
        $this->_vars = $vars;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        
        return $this;
    }

    /**
     * Import object from stdClass
     *
     * @param string $json
     * @return Item
     */
    public function importStdClass($obj, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        if (!$obj->id || !$obj->qty) {
            return false;
        }

        $id = isset($obj->id) ? $obj->id : '';
        $sku = isset($obj->sku) ? $obj->sku : '';
        $name = isset($obj->name) ? $obj->name : '';
        $price = isset($obj->price) ? $obj->price : 0;
        $qty = isset($obj->qty) ? $obj->qty : 0;
        $provider = isset($data['provider']) ? $data['provider'] : 0;
        $custom = isset($obj->custom) ? $obj->custom : array();
        $isTaxable = isset($obj->is_taxable) ? $obj->is_taxable : false;
        $isDiscountable = isset($obj->is_discountable) ? $obj->is_discountable : true;
        
        $this->_id = $id;
        $this->_sku = $sku;
        $this->_name = $name;
        $this->_price = $price;
        $this->_qty = $qty;
        $this->_provider = $provider;
        $this->_custom = $custom;
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;
        
        $this->_custom = array(); // this doesnt apply
        $this->_vars = array(); // this could apply
        
        return $this;
    }

    /**
     *
     */
    public function importEntity($entity)
    {
        $this->reset();

        $id = $entity->getId();
        $sku = $entity->getSku();
        $name = $entity->getName();
        $price = $entity->getPrice(); // more prices?
        $qty = abs($entity->getQty());
        $provider = $entity->getProvider();

        $custom = array(); // this doesnt apply. this is for personalizing items in the cart
        $vars = array(); // this could apply

        $isTaxable = $entity->getIsTaxable();
        $isDiscountable = $entity->getIsDiscountable();

        $this->_id = $id;
        $this->_sku = $sku;
        $this->_name = $name;
        $this->_price = $price;
        $this->_qty = $qty;
        $this->_provider = $provider;
        $this->_custom = $custom;
        $this->_vars = $vars; // todo
        $this->_isTaxable = $isTaxable;
        $this->_isDiscountable = $isDiscountable;

        return $this;
    }

    /**
     * Reset object to default values
     *
     * @return Item
     */
    public function reset()
    {
        $this->_id = 0;
        $this->_sku = '';
        $this->_name = '';
        $this->_price = 0;
        $this->_qty = 0;
        $this->_provider = 0;
        $this->_custom = array();
        $this->_vars = array();
        $this->_isTaxable = false;
        $this->_isDiscountable = true;
        return $this;
    }

    /**
     * Check if this Item validates a condition
     *
     * @param DiscountCondition
     * @return bool
     */
    public function isValidCondition(DiscountCondition $condition)
    {
        switch($condition->getSourceEntityField()) {
            case 'price':
                $condition->setSourceValue($this->getPrice());
                break;
            case 'weight':
                $condition->setSourceValue($this->getWeight());
                break;
            case 'sku':
                $condition->setSourceValue($this->getSku());
                break;
            case 'qty':
                $condition->setSourceValue($this->getQty());
                break;
            case 'category_ids_csv':
                $condition->setSourceValue($this->getCategoryIdsCsv());
                break;
        }

        return $condition->isValid();
    }

    /**
     * Check if this item validates a tree of conditions
     *
     * @param DiscountConditionCompare
     * @return bool
     */
    public function isValidConditionCompare(DiscountConditionCompare $compare)
    {
        return $compare->isValid($this);
    }
    
    /**
     * Getter for product id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Setter for product Id
     *
     * @param int $id
     * @return Item
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Getter for sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->_sku;
    }

    /**
     * Set sku
     *
     * @param string
     * @return Item
     */
    public function setSku($sku)
    {
        $this->_sku = $sku;
        return $this;
    }

    /**
     * Getter for product name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set product name
     *
     * @param string
     * @return Item
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Set price of product
     *
     * @param float $price
     * @return Item
     */
    public function setPrice($price)
    {
        $this->_price = $price;
        return $this;
    }

    /**
     * Accessor for product price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     * Set quantity of item in cart
     *
     * @param int|float
     * @return Item
     */
    public function setQty($qty)
    {
        $this->_qty = abs($qty);
        return $this;
    }

    /**
     * Getter for quantity
     *
     * @return int|float
     */
    public function getQty()
    {
        return $this->_qty;
    }

    public function setProvider($providerId)
    {
        $this->_provider = intval($providerId);
        return $this;
    }

    public function getProvider()
    {
        return $this->_provider;
    }
    
    /**
     * Retrieve whether this item is taxable
     *
     * @return bool
     */
    public function getIsTaxable()
    {
        return $this->_isTaxable;
    }

    /**
     * Set whether this item is taxable
     * 
     * @param bool $isTaxable
     * @return Item
     */
    public function setIsTaxable($isTaxable)
    {
        $this->_isTaxable = $isTaxable;
        return $this;
    }

    /**
     * Retrieve whether this item is discountabel
     *
     * @return bool
     */
    public function getIsDiscountable()
    {
        return $this->_isDiscountable;
    }

    /**
     * Set whether this item is discountable
     *
     * @param bool $isDiscountable
     * @return Item
     */
    public function setIsDiscountable($isDiscountable)
    {
        $this->_isDiscountable = $isDiscountable;
        return $this;
    }

    /**
     * Getter for category Ids CSV
     *
     * @return string comma-separated values
     */
    public function getCategoryIdsCsv()
    {
        return $this->_categoryIdsCsv;
    }

    /**
     * Set category Ids CSV
     *
     * @param string
     * @return Item
     */
    public function setCategoryIdsCsv($categoryIds)
    {
        $this->_categoryIdsCsv = $categoryIds;
        return $this;
    }

    /**
     * Getter for custom product variables
     *
     * @return array
     */
    public function getCustom()
    {
        return $this->_custom;
    }
    
    /**
     * Set custom product variable
     *
     * @param string $key
     * @param string $value
     * @return Item
     */
    public function setCustom($key, $value)
    {
        $this->_custom[$key] = $value;
        return $this;
    }
    
    /**
     * Remove custom product variable
     *
     * @param string $key
     * @return Item
     */
    public function unsetCustom($key)
    {
        if (isset($this->_custom[$key])) {
            unset($this->_custom[$key]);
        }
        return $this;
    }

    /**
     * Retrieve whether this item has customized variables
     *
     * @return bool
     */
    public function hasCustom($key)
    {
        return isset($this->_custom[$key]);
    }

    /**
     * Getter for product variables
     *
     * @return array
     */
    public function getVars()
    {
        return $this->_vars;
    }
    
    /**
     * Set product variable
     *
     * @param string $key
     * @param string $value
     * @return Item
     */
    public function setVar($key, $value)
    {
        $this->_vars[$key] = $value;
        return $this;
    }
    
    /**
     * Remove product variable
     *
     * @param string $key
     * @return Item
     */
    public function unsetVar($key)
    {
        if (isset($this->_vars[$key])) {
            unset($this->_vars[$key]);
        }
        return $this;
    }

    /**
     * Retrieve whether this item has any product variables
     *
     * @return bool
     */
    public function hasVar($key)
    {
        return isset($this->_vars[$key]);
    }
    
}