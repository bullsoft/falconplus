<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-19 18:12:24$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class UserInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var unknown
     * @table user_info
     */
    public $id = null;

    /**
     * @var string
     * @table user_info
     */
    public $mobile = '';

    /**
     * @var string
     * @table user_info
     */
    public $salt = '';

    /**
     * @var string
     * @table user_info
     */
    public $passwd = '';

    /**
     * @var string
     * @table user_info
     */
    public $email = null;

    /**
     * @var string
     * @table user_info
     */
    public $nickname = null;

    /**
     * @var string
     * @table user_info
     */
    public $open_id = null;

    /**
     * @var integer
     * @table user_info
     */
    public $device_id = null;

    /**
     * @var string
     * @table user_info
     */
    public $refer = null;

    /**
     * @var unknown
     * @table user_info
     */
    public $points = '0';

    /**
     * @var unknown
     * @table user_info
     */
    public $invite_user_id = null;

    /**
     * @var string
     * @table user_info
     */
    public $invite_code = null;

    /**
     * @var integer
     * @table user_info
     */
    public $status = null;

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
        $this->mobile = '';
        $this->salt = '';
        $this->passwd = '';
        $this->email = NULL;
        $this->nickname = NULL;
        $this->openId = NULL;
        $this->deviceId = NULL;
        $this->refer = NULL;
        $this->points = '0';
        $this->inviteUserId = NULL;
        $this->inviteCode = NULL;
        $this->status = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'mobile' => 'mobile', 
            'salt' => 'salt', 
            'passwd' => 'passwd', 
            'email' => 'email', 
            'nickname' => 'nickname', 
            'open_id' => 'openId', 
            'device_id' => 'deviceId', 
            'refer' => 'refer', 
            'points' => 'points', 
            'invite_user_id' => 'inviteUserId', 
            'invite_code' => 'inviteCode', 
            'status' => 'status', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'user_info';
    }


}

