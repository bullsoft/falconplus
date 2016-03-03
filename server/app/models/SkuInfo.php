<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: SkuInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-03-03 14:24:47$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class SkuInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table sku_info
     */
    public $discount = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $id = null;

    /**
     * @var string
     * @table sku_info
     */
    public $name = null;

    /**
     * @var string
     * @table sku_info
     */
    public $slogan = null;

    /**
     * @var integer
     * @table sku_info
     */
    public $product_id = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $seller_id = null;

    /**
     * @var integer
     * @table sku_info
     */
    public $cate_id = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $price = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $amount = null;

    /**
     * @var integer
     * @table sku_info
     */
    public $discount_id = '0';

    /**
     * @var integer
     * @table sku_info
     */
    public $sell_type = '1';

    /**
     * @var integer
     * @table sku_info
     */
    public $is_delete = '1';

    /**
     * @var integer
     * @table sku_info
     */
    public $status = '0';

    /**
     * @var unknown
     * @table sku_info
     */
    public $btime = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $etime = null;

    /**
     * @var unknown
     * @table sku_info
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table sku_info
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
        $this->name = NULL;
        $this->slogan = NULL;
        $this->productId = NULL;
        $this->sellerId = NULL;
        $this->cateId = NULL;
        $this->price = NULL;
        $this->amount = NULL;
        $this->discountId = '0';
        $this->sellType = '1';
        $this->isDelete = '1';
        $this->status = '0';
        $this->btime = NULL;
        $this->etime = NULL;
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
            'name' => 'name', 
            'slogan' => 'slogan', 
            'product_id' => 'productId', 
            'seller_id' => 'sellerId', 
            'cate_id' => 'cateId', 
            'price' => 'price', 
            'amount' => 'amount', 
            'discount_id' => 'discountId', 
            'sell_type' => 'sellType', 
            'is_delete' => 'isDelete', 
            'status' => 'status', 
            'btime' => 'btime', 
            'etime' => 'etime', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'sku_info';
    }


}

