<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
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
    public $email = '';

    /**
     * @var integer
     * @table user_info
     */
    public $is_email_verified = '0';

    /**
     * @var string
     * @table user_info
     */
    public $nickname = '';

    /**
     * @var string
     * @table user_info
     */
    public $open_id = '';

    /**
     * @var integer
     * @table user_info
     */
    public $device_id = '0';

    /**
     * @var string
     * @table user_info
     */
    public $refer = 'HOME';

    /**
     * @var unknown
     * @table user_info
     */
    public $points = '0';

    /**
     * @var unknown
     * @table user_info
     */
    public $invite_user_id = '0';

    /**
     * @var string
     * @table user_info
     */
    public $invite_code = '';

    /**
     * @var integer
     * @table user_info
     */
    public $status = '0';

    /**
     * @var unknown
     * @table user_info
     */
    public $ctime = null;

    /**
     * @var unknown
     * @table user_info
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
        $this->mobile = '';
        $this->salt = '';
        $this->passwd = '';
        $this->email = '';
        $this->isEmailVerified = '0';
        $this->nickname = '';
        $this->openId = '';
        $this->deviceId = '0';
        $this->refer = 'HOME';
        $this->points = '0';
        $this->inviteUserId = '0';
        $this->inviteCode = '';
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
            'mobile' => 'mobile', 
            'salt' => 'salt', 
            'passwd' => 'passwd', 
            'email' => 'email', 
            'is_email_verified' => 'isEmailVerified', 
            'nickname' => 'nickname', 
            'open_id' => 'openId', 
            'device_id' => 'deviceId', 
            'refer' => 'refer', 
            'points' => 'points', 
            'invite_user_id' => 'inviteUserId', 
            'invite_code' => 'inviteCode', 
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
        return 'user_info';
    }


}

