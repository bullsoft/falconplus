<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserAddress
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-19 18:12:24$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class UserAddress extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table user_address
     */
    public $id = null;

    /**
     * @var integer
     * @table user_address
     */
    public $user_id = null;

    /**
     * @var integer
     * @table user_address
     */
    public $province = null;

    /**
     * @var integer
     * @table user_address
     */
    public $city = null;

    /**
     * @var integer
     * @table user_address
     */
    public $county = null;

    /**
     * @var integer
     * @table user_address
     */
    public $detail = null;

    /**
     * @var integer
     * @table user_address
     */
    public $postcode = null;

    /**
     * @var integer
     * @table user_address
     */
    public $telephone = null;

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
        $this->userId = NULL;
        $this->province = NULL;
        $this->city = NULL;
        $this->county = NULL;
        $this->detail = NULL;
        $this->postcode = NULL;
        $this->telephone = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'user_id' => 'userId', 
            'province' => 'province', 
            'city' => 'city', 
            'county' => 'county', 
            'detail' => 'detail', 
            'postcode' => 'postcode', 
            'telephone' => 'telephone', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'user_address';
    }


}

