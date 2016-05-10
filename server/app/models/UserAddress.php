<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserAddress
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-10 18:02:33$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class UserAddress extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table user_address
     */
    public $county = null;

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
     * @var string
     * @table user_address
     */
    public $province = null;

    /**
     * @var string
     * @table user_address
     */
    public $city = null;

    /**
     * @var string
     * @table user_address
     */
    public $district = null;

    /**
     * @var string
     * @table user_address
     */
    public $detail = null;

    /**
     * @var string
     * @table user_address
     */
    public $postcode = null;

    /**
     * @var string
     * @table user_address
     */
    public $mobile = null;

    /**
     * @var string
     * @table user_address
     */
    public $telephone = null;

    /**
     * @var unknown
     * @table user_address
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table user_address
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
        $this->userId = NULL;
        $this->province = NULL;
        $this->city = NULL;
        $this->district = NULL;
        $this->detail = NULL;
        $this->postcode = NULL;
        $this->mobile = NULL;
        $this->telephone = NULL;
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
            'user_id' => 'userId', 
            'province' => 'province', 
            'city' => 'city', 
            'district' => 'district', 
            'detail' => 'detail', 
            'postcode' => 'postcode', 
            'mobile' => 'mobile', 
            'telephone' => 'telephone', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
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

