<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-03-02 19:02:14$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealRecord extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table deal_record
     */
    public $investor_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $borrower_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $deal_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $buyer_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $buyer_addr_id = '0';

    /**
     * @var integer
     * @table deal_record
     */
    public $seller_id = null;

    /**
     * @var string
     * @table deal_record
     */
    public $cart_uuid = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $discount_id = '0';

    /**
     * @var integer
     * @table deal_record
     */
    public $shipment_id = '0';

    /**
     * @var integer
     * @table deal_record
     */
    public $amount = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $status = '0';

    /**
     * @var unknown
     * @table deal_record
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table deal_record
     */
    public $mtime = '0000-00-00 00:00:00';

    public function initialize()
    {
        parent::initialize();
        $this->setConnectionService("dbDemo");
    }

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->buyerId = NULL;
        $this->buyerAddrId = '0';
        $this->sellerId = NULL;
        $this->cartUuid = NULL;
        $this->discountId = '0';
        $this->shipmentId = '0';
        $this->amount = NULL;
        $this->status = '0';
        $this->ctime = '0000-00-00 00:00:00';
        $this->mtime = '0000-00-00 00:00:00';
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'buyer_id' => 'buyerId', 
            'buyer_addr_id' => 'buyerAddrId', 
            'seller_id' => 'sellerId', 
            'cart_uuid' => 'cartUuid', 
            'discount_id' => 'discountId', 
            'shipment_id' => 'shipmentId', 
            'amount' => 'amount', 
            'status' => 'status', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'deal_record';
    }


}

