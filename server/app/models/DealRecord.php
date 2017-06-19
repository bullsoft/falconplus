<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealRecord extends \PhalconPlus\Base\Model
{

    /**
     * @var string
     * @table deal_record
     */
    public $cart_uuid = null;

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
    public $deal_no = '';

    /**
     * @var string
     * @table deal_record
     */
    public $cart_no = '';

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
    public $ctime = null;

    /**
     * @var unknown
     * @table deal_record
     */
    public $mtime = null;

    public function initialize()
    {
        parent::initialize();
        $this->setWriteConnectionService("dbDemo");
        $this->setReadConnectionService("dbDemo_r");
        $this->hasMany("cartNo", __NAMESPACE__."\\CartInfo", "cartNo", [
            'alias' => "RelatedCartDetails"
        ]);
        $this->belongsTo("buyerId", __NAMESPACE__."\\UserInfo", "id", [
            'alias' => 'RelatedUserInfo'
        ]);
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
        $this->dealNo = '';
        $this->cartNo = '';
        $this->discountId = '0';
        $this->shipmentId = '0';
        $this->amount = NULL;
        $this->status = '0';
        $this->ctime = NULL;
        $this->mtime = NULL;
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
            'deal_no' => 'dealNo', 
            'cart_no' => 'cartNo', 
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

