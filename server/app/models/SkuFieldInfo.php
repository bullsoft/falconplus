<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: SkuFieldInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class SkuFieldInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $id = null;

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $sku_id = null;

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $product_id = null;

    /**
     * @var integer
     * @table sku_field_info
     */
    public $cate_id = null;

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $field_id = null;

    /**
     * @var string
     * @table sku_field_info
     */
    public $field_value = null;

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $ctime = null;

    /**
     * @var unknown
     * @table sku_field_info
     */
    public $mtime = null;

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
        $this->skuId = NULL;
        $this->productId = NULL;
        $this->cateId = NULL;
        $this->fieldId = NULL;
        $this->fieldValue = NULL;
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
            'sku_id' => 'skuId', 
            'product_id' => 'productId', 
            'cate_id' => 'cateId', 
            'field_id' => 'fieldId', 
            'field_value' => 'fieldValue', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'sku_field_info';
    }


}

