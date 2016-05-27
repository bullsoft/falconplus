<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: CartInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-25 14:36:39$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class CartInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var string
     * @table cart_info
     */
    public $uuid = null;

    /**
     * @var unknown
     * @table cart_info
     */
    public $id = null;

    /**
     * @var string
     * @table cart_info
     */
    public $cart_no = null;

    /**
     * @var string
     * @table cart_info
     */
    public $session_id = null;

    /**
     * @var unknown
     * @table cart_info
     */
    public $sku_id = null;

    /**
     * @var unknown
     * @table cart_info
     */
    public $product_id = null;

    /**
     * @var unknown
     * @table cart_info
     */
    public $user_id = null;

    /**
     * @var unknown
     * @table cart_info
     */
    public $seller_id = null;

    /**
     * @var integer
     * @table cart_info
     */
    public $price = null;

    /**
     * @var integer
     * @table cart_info
     */
    public $qty = null;

    /**
     * @var integer
     * @table cart_info
     */
    public $is_delete = '0';

    /**
     * @var integer
     * @table cart_info
     */
    public $status = '0';

    /**
     * @var unknown
     * @table cart_info
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table cart_info
     */
    public $mtime = '0000-00-00 00:00:00';

    public function initialize()
    {
        parent::initialize();
        $this->setWriteConnectionService("dbDemo");
        $this->setReadConnectionService("dbDemo_r");
    }

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->cartNo = NULL;
        $this->sessionId = NULL;
        $this->skuId = NULL;
        $this->productId = NULL;
        $this->userId = NULL;
        $this->sellerId = NULL;
        $this->price = NULL;
        $this->qty = NULL;
        $this->isDelete = '0';
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
            'cart_no' => 'cartNo', 
            'session_id' => 'sessionId', 
            'sku_id' => 'skuId', 
            'product_id' => 'productId', 
            'user_id' => 'userId', 
            'seller_id' => 'sellerId', 
            'price' => 'price', 
            'qty' => 'qty', 
            'is_delete' => 'isDelete', 
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
        return 'cart_info';
    }


}

