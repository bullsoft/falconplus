<?php

namespace BullSoft\Cart;

class Cart
{
    /**
     * @var int id The database row Id 
     */
    protected $_id;

    /**
     * @var Customer
     */
    protected $_customer;

    /**
     * @var array products
     */
    protected $_items; // items[prefix-productId] = Item
    
    /**
     * @var array discounts
     */
    protected $_discounts; // discounts[prefix-discountId] = Discount
    
    /**
     * @var array shipments
     */
    protected $_shipments; // shipments[company-method] = Shipment

    /**
     * Flag whether including tax in total 
     *
     * @var bool
     */
    protected $_includeTax; // enable/disable per state

    /**
     * Tax rate eg 0.08
     *
     * @var float
     */
    protected $_taxRate; // per state / county

    /**
     * Decimal point precision, based on customer country
     *
     * @var int
     */
    protected $_precision; // from config

    /**
     * Decimal point precision for Calculator
     *  If a tax rate is .07025 , and a subtotal is 1000
     *   70.25 should be charged for tax, not 70.00
     *
     * @var int
     */
    protected $_calculatorPrecision = 4; //from config

    /**
     * Flag whether to discount taxable subtotal first or last.
     *  This is only effective if the sum of pre-tax discounts "overlaps" 
     *  the sum of taxable items/shipments; which reduces the taxable subtotal,
     *  and ultimately the amount of tax being paid for
     *
     * @var bool
     */
    protected $_discountTaxableLast; //from config
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Retrieve calculator with current Cart instance
     *
     * @return Calculator
     */
    public function getCalculator()
    {
        return new Calculator($this);
    }

    /**
     * Get current cart totals from calculator
     *
     * @return array
     */
    public function getTotals()
    {
        return $this->getCalculator()->getTotals();
    }

    /**
     * Get item/shipment discounts from calculator
     *
     * @return array
     */
    public function getDiscountGrid()
    {
        return $this->getCalculator()->getDiscountGrid();
    }

    /**
     * Get current discounted cart totals from calculator
     *
     * @return array
     */
    public function getDiscountedTotals()
    {
        return $this->getCalculator()->getDiscountedTotals();
    }

    /**
     * Enable string casting for this class
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Export this cart as a json string
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Export this cart as an array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'                    => $this->getId(),
            'customer'              => $this->getCustomer()->toArray(),
            'items'                 => $this->getItemsAsArray(),
            'discounts'             => $this->getDiscountsAsArray(),
            'shipments'             => $this->getShipmentsAsArray(),
            'tax_rate'              => $this->getTaxRate(),
            'include_tax'           => $this->getIncludeTax(),
            'discount_taxable_last' => $this->getDiscountTaxableLast(),
        );
    }

    /**
     * Export cart discounts as an associative array
     *
     * @return array of Discounts
     */
    public function getDiscountsAsArray()
    {
        $discounts = array();
        if (count($this->_discounts) > 0) {
            foreach($this->_discounts as $discountKey => $discount) {
                $discounts[$discountKey] = $discount->toArray();
            }
        }
        return $discounts;
    }

    /**
     * Export cart items as an associative array
     *
     * @return array of Items
     */
    public function getItemsAsArray()
    {
        $items = array();
        if (count($this->_items) > 0) {
            foreach($this->_items as $productKey => $product) {
                $items[$productKey] = $product->toArray();
            }
        }
        return $items;
    }

    /**
     * Export cart shipments as an associative array
     *
     * @return array of Shipments
     */
    public function getShipmentsAsArray()
    {
        $shipments = array();
        if (count($this->_shipments) > 0) {
            foreach($this->_shipments as $shipmentKey => $shipment) {
                $shipments[$shipmentKey] = $shipment->toArray();
            }
        }
        return $shipments;
    }
    
    /**
     * Import object data from json string.
     * Note: Watch out for single index arrays becoming stdClass objects
     *
     * @param string JSON
     * @param bool
     * @return Cart
     */
    public function importJson($json, $reset = true)
    {
        // strict parameter
        if (!is_string($json)) {
            return false;
        }
        
        // reset cart
        if ($reset) {
            $this->reset();
        }
        
        $cart = @ (array) json_decode($json, true); // just gimme an array

        if (isset($cart['id'])) {
            $this->setId($cart['id']);
        }

        if (isset($cart['customer'])) {
            $customerData = $cart['customer'];
            $customer = new Customer();
            if (is_array($customerData)) {
                $customer->importJson(json_encode($customerData));
                $this->setCustomer($customer);
            }
        }
        
        if (isset($cart['items']) && count($cart['items']) > 0) {
            $items = $cart['items'];
            foreach($items as $productKey => $item) {
                $itemJson = json_encode($item);
                $item = new Item();
                $item->importJson($itemJson);
                $this->setItem($item);
            }
        }

        if (isset($cart['shipments']) && count($cart['shipments']) > 0) {
            $shipments = $cart['shipments'];
            foreach($shipments as $shipmentKey => $shipment) {
                $tmpShipment = new Shipment();
                if ($shipment instanceof stdClass) {
                    $tmpShipment->importStdClass($shipment);
                    $this->setShipment($tmpShipment);
                } else if (is_array($shipment)) {
                    $tmpShipment->importJson(json_encode($shipment));
                    $this->setShipment($tmpShipment);
                }
            }
        }
        
        if (isset($cart['discounts']) && count($cart['discounts']) > 0) {
            $discounts = $cart['discounts'];
            foreach($discounts as $discountKey => $discount) {
                $tmpDiscount = new Discount();
                if ($discount instanceof stdClass) {
                    $tmpDiscount->importStdClass($discount);
                    $this->setDiscount($tmpDiscount);
                } else if (is_array($tmpDiscount)) {
                    $tmpDiscount->importJson(json_encode($discount));
                    $this->setDiscount($tmpDiscount);
                }
            }
        }

        if (isset($cart['include_tax'])) {
            $includeTax = $cart['include_tax'];
            $this->setIncludeTax($includeTax);
        }

        if (isset($cart['tax_rate'])) {
            $taxRate = $cart['tax_rate'];
            $this->setTaxRate($taxRate);
        }

        if (isset($cart['discount_taxable_last'])) {
            $discountTaxableLast = $cart['discount_taxable_last'];
            $this->setDiscountTaxableLast($discountTaxableLast);
        }
        
        return $this;
    }
    
    /**
     * Reset this cart instance
     *
     * @return Cart
     */
    public function reset()
    {
        $this->_id = 0;
        $this->_customer = new Customer();
        $this->_items = array();
        $this->_discounts = array();
        $this->_shipments = array();
        $this->_includeTax = false;
        $this->_taxRate = 0.0;
        $this->_precision = 2;
        $this->_calculatorPrecision = 4;
        $this->_discountTaxableLast = true;

        return $this;
    }

    /**
     * Validate a DiscountCondition against this Cart instance
     *
     * @param DiscountCondition
     * @return bool
     */
    public function isValidCondition(DiscountCondition $condition)
    {
        /*
        Note: the Discount system is not using this yet
        */
        switch($condition->getSourceField()) {
            case 'total':
                $condition->setSourceValue($this->getCalculator()->getTotal());
                break;
            case 'item_total':
                $condition->setSourceValue($this->getCalculator()->getItemTotal());
                break;
            case 'shipment_total':
                $condition->setSourceValue($this->getCalculator()->getShipmentTotal());
                break;
            case 'discounted_item_total':
                $condition->setSourceValue($this->getCalculator()->getDiscountedItemTotal());
                break;
            case 'discounted_shipment_total':
                $condition->setSourceValue($this->getCalculator()->getDiscountedShipmentTotal());
                break;
            default:
                //no-op
                break;
        }

        return $condition->isValid();
    }

    /**
     * Set decimal point precision
     *
     * @return Cart
     */
    public function setPrecision($precision)
    {
        $this->_precision = (int) $precision;
        return $this;
    }

    /**
     * Get decimal point precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return $this->_precision;
    }

    /**
     * Set decimal point precision
     */
    public function setCalculatorPrecision($precision)
    {
        $this->_calculatorPrecision = (int) $precision;
        return $this;
    }

    /**
     * Get decimal point precision
     *
     * @return int
     */
    public function getCalculatorPrecision()
    {
        return $this->_calculatorPrecision;
    }

    /**
     * Set your Id on this cart
     *
     * @return mixed
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Get the Id set on this cart
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Update this cart's Customer
     *
     * @param Customer
     * @return Cart
     */
    public function setCustomer(Customer $customer)
    {
        $this->_customer = $customer;
        return $this;
    }

    /**
     * Get the customer for this cart
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->_customer;
    }

    /**
     * Get all items from this cart
     *
     * @return array of Items
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Retrieve Item
     *
     * @param string
     * @return Item|false
     */
    public function getItem($key, $isKey = true)
    {
        if (!$isKey) {
            $key = Item::getKey($key);
        }
        return isset($this->_items[$key]) ? $this->_items[$key] : false;
    }

    /**
     * Add/update Item in cart 
     *
     * @param Item
     * @return Cart
     */
    public function setItem(Item $item)
    {
        $key = Item::getKey($item->getId());
        $this->_items[$key] = $item;
        return $this;
    }

    /**
     * Remove item from cart
     *
     * @param string|Item
     * @return Cart
     */
    public function unsetItem($key, $isKey = true)
    {
        if ($key instanceof Item) {
            $key = Item::getKey($key->getId());
        } else if (!$isKey) {
            $key = Item::getKey($key);
        }

        if (isset($this->_items[$key])) {
            unset($this->_items[$key]);
        }
        
        if ($this->hasDiscounts()) {
            foreach($this->getDiscounts() as $discountKey => $discount) {
                if ($discount->hasItem($key)) {
                    $discount->unsetItem($key);
                }
                if ($discount->getTo() == Discount::$toSpecified &&
                    !$discount->hasItems() &&
                    !$discount->hasShipments()) {
                    
                    $this->unsetDiscount($key);
                }
            }
        }

        return $this;
    }

    /**
     * Assert this cart instance has Items
     *
     * @return bool
     */
    public function hasItems()
    {
        return (count($this->getItems()) > 0);
    }

    /**
     * Assert Item exists
     *
     * @param string itemKey
     * @return bool hasItem
     */
    public function hasItem($key, $isKey = true)
    {
        if (!$isKey) {
        	if($key instanceof Item) {
        		$key = Item::getKey($key->getId());
        	} else {
            	$key = Item::getKey($key);
			}
        }
        return isset($this->_items[$key]);
    }

    /**
     * Get keys of shipments that have been specified in discounts
     * This helps with separating specific discounts
     *
     * @return array
     */
    public function getSpecifiedDiscountItemKeys()
    {
        $keys = array();
        if (count($this->getDiscounts()) > 0) {
            foreach($this->getDiscounts() as $key => $discount) {

                if ($discount->getTo() != Discount::$toSpecified) {
                    continue;
                }

                $shipments = $discount->getItems();
                if (count($discount->getItems()) > 0) {
                    foreach($discount->getItems() as $itemKey => $qty) {
                        $keys[$itemKey] = $itemKey;
                    }
                }
            }
        }
        return $keys;
    }

    /**
     * Return array of Discounts
     *
     * @return array
     */
    public function getDiscounts($sortByPriority = false)
    {
        if (!$sortByPriority) {
            return $this->_discounts;
        }

        $discounts = array();
        if (!count($this->_discounts)) {
            return $this->_discounts;
        }

        $sortedKeys = $this->getPrioritizedDiscountKeys();
        foreach($sortedKeys as $key => $priority) {
            $discounts[$key] = $this->getDiscount($key);
        }

        return $discounts;
    }

    /**
     * Get discount keys, sorted by priority
     *
     * @return array
     */
    public function getPrioritizedDiscountKeys()
    {
        $priorities = array();
        if (!$this->hasDiscounts()) {
            return $priorities;
        }

        foreach($this->getDiscounts() as $key => $discount) {
            $priorities[$key] = $discount->getPriority();
        }

        asort($priorities);
        return $priorities;
    }



    /**
     * Retrieve Discount
     *
     * @return Discount|false
     */
    public function getDiscount($key, $isKey = true)
    {
        if (!$isKey) {
            $key = Discount::getKey($key);
        }
        return isset($this->_discounts[$key]) ? $this->_discounts[$key] : false;
    }

    /**
     * Add Discount to cart
     *
     * @param Discount
     * @return Cart
     */
    public function setDiscount(Discount $discount)
    {
        $key = Discount::getKey($discount->getId());
        $this->_discounts[$key] = $discount;
        return $this;
    }
    
    /**
     * Remove Discount from cart by key, instance, or Id
     *
     * @param string
     * @return Cart
     */
    public function unsetDiscount($key, $isKey = true)
    {
        if ($key instanceof Discount) {
            $key = Discount::getKey($key->getId());
        } else if (!$isKey) {
            $key = Discount::getKey($key);
        }

        if (isset($this->_discounts[$key])) {
            unset($this->_discounts[$key]);
        }

        return $this;
    }

    /**
     * Assert Discount exists, by key or Id
     *
     * @param string discountKey
     * @param bool is key already prefixed
     * @return bool hasDiscount
     */
    public function hasDiscount($key, $isKey = true)
    {
        if (!$isKey) {
            $key = Discount::getKey($key);
        }
        return isset($this->_discounts[$key]);
    }

    /**
     * Assert this cart has discounts
     *
     * @return bool
     */
    public function hasDiscounts()
    {
        return (count($this->getDiscounts()) > 0);
    }

    /**
     * Return array of Shipments
     *
     * @return array
     */
    public function getShipments()
    {
        return $this->_shipments;
    }

    /**
     * Retrieve Shipment by key or Id
     *
     * @return Shipment|false
     */
    public function getShipment($key, $isKey = true)
    {
        if (!$isKey) {
            $key = Shipment::getKey($key);
        }
        return isset($this->_shipments[$key]) ? $this->_shipments[$key] : false;
    }

    /**
     * Add Shipment to cart
     *
     * @param Shipment
     * @return Cart
     */
    public function setShipment(Shipment $shipment)
    {
        $key = Shipment::getKey($shipment->getId());
        $this->_shipments[$key] = $shipment;
        return $this;
    }

    /**
     * Remove Shipment from cart by key, instance or Id
     *
     * @param string key : associative array key
     * @param bool is key already prefixed
     * @return Cart
     */
    public function unsetShipment($key, $isKey = true)
    {
        if ($key instanceof Shipment) {
            $key = Shipment::getKey($key->getId());
        } else if (!$isKey) {
            $key = Shipment::getKey($key);
        }

        if (isset($this->_shipments[$key])) {
            unset($this->_shipments[$key]);
        }

        //TODO: remove from discounts

        return $this;
    }

    /**
     * Assert Shipment exists
     *
     * @param string shipmentKey
     * @param bool is key already prefixed
     * @return bool hasShipment
     */
    public function hasShipment($key, $isKey = true)
    {
        if (!$isKey) {
            $key = Shipment::getKey($key);
        }
        return isset($this->_shipments[$key]);
    }

    /**
     * Assert this cart has shipments
     *
     * @return bool
     */
    public function hasShipments()
    {
        return (count($this->getShipments()) > 0);
    }

    /**
     * Get keys of shipments that have been specified in discounts
     *
     * @return array
     */
    public function getSpecifiedDiscountShipmentKeys()
    {
        $keys = array();
        if (count($this->getDiscounts()) > 0) {
            foreach($this->getDiscounts() as $key => $discount) {
                if ($discount->getTo() != Discount::$toSpecified) {
                    continue;
                }

                $shipments = $discount->getShipments();
                if (count($discount->getShipments()) > 0) {
                    foreach($discount->getShipments() as $shipmentKey => $value) {
                        $keys[$shipmentKey] = $shipmentKey;
                    }
                }
            }
        }
        return $keys;
    }

    /**
     * Get Discounts before Tax
     *
     * @return array
     */
    public function getPreTaxDiscounts()
    {
        $discounts = array();

        if (!count($this->getDiscounts())) {
            return $discounts;
        }

        foreach($this->getDiscounts() as $discountKey => $discount) {
            if ($discount->getIsPreTax()) {
                $discounts[$discountKey] = $discount;
            }
        }

        return $discounts;
    }

    /**
     * Get Discounts after Tax
     *  gets all discounts regardless of type
     *
     * @return array
     */
    public function getPostTaxDiscounts()
    {
        $discounts = array();
        if (!count($this->getDiscounts())) {
            return $discounts;
        }
        foreach($this->getDiscounts() as $discountKey => $discount) {
            if (!$discount->getIsPreTax()) {
                $discounts[$discountKey] = $discount;
            }
        }
        return $discounts;
    }

    /**
     * Retrieve tax rate
     *
     * @return string formatted as a numerical float
     */
    public function getTaxRate()
    {
        return $this->_taxRate;
    }

    /**
     * Set tax rate
     *
     * @param string|float
     * @return Cart
     */
    public function setTaxRate($taxRate)
    {
        $this->_taxRate = $taxRate;
        return $this;
    }

    /**
     * Retrieve whether tax is enabled
     *
     * @return bool
     */
    public function getIncludeTax()
    {
        return $this->_includeTax;
    }

    /**
     * Update whether tax is enabled
     *
     * @return Cart
     */
    public function setIncludeTax($includeTax)
    {
        $this->_includeTax = $includeTax;
        return $this;
    }

    /**
     * Check whether taxable is discounted last
     *
     * @return bool
     */
    public function getDiscountTaxableLast()
    {
        return $this->_discountTaxableLast;
    }

    /**
     * Update whether taxable is discounted last
     *
     * @return Cart
     */
    public function setDiscountTaxableLast($discountTaxableLast)
    {
        $this->_discountTaxableLast = $discountTaxableLast;
        return $this;
    }

}
