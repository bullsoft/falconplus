<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: SkuFieldInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-03-03 14:24:47$
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
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table sku_field_info
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
        $this->skuId = NULL;
        $this->productId = NULL;
        $this->cateId = NULL;
        $this->fieldId = NULL;
        $this->fieldValue = NULL;
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

