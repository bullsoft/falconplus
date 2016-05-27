<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: ProductInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-25 14:36:39$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class ProductInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var unknown
     * @table product_info
     */
    public $id = null;

    /**
     * @var string
     * @table product_info
     */
    public $name = '';

    /**
     * @var unknown
     * @table product_info
     */
    public $price = null;

    /**
     * @var string
     * @table product_info
     */
    public $slogan = null;

    /**
     * @var string
     * @table product_info
     */
    public $intro = null;

    /**
     * @var integer
     * @table product_info
     */
    public $cate_id = '0';

    /**
     * @var integer
     * @table product_info
     */
    public $brand_id = null;

    /**
     * @var integer
     * @table product_info
     */
    public $need_shipped = null;

    /**
     * @var unknown
     * @table product_info
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table product_info
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
        $this->name = '';
        $this->price = NULL;
        $this->slogan = NULL;
        $this->intro = NULL;
        $this->cateId = '0';
        $this->brandId = NULL;
        $this->needShipped = NULL;
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
            'price' => 'price', 
            'slogan' => 'slogan', 
            'intro' => 'intro', 
            'cate_id' => 'cateId', 
            'brand_id' => 'brandId', 
            'need_shipped' => 'needShipped', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'product_info';
    }


}

