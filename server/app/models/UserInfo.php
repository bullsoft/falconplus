<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-12 17:30:52$
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
    public $mobile = null;

    /**
     * @var string
     * @table user_info
     */
    public $passwd = null;

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
    public $points = null;

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

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->mobile = NULL;
        $this->passwd = NULL;
        $this->email = NULL;
        $this->nickname = NULL;
        $this->openId = NULL;
        $this->deviceId = NULL;
        $this->refer = NULL;
        $this->points = NULL;
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

    public function initialize()
    {
        parent::initialize();
        $this->setConnectionService("dbDemo");
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'user_info';
    }


}

