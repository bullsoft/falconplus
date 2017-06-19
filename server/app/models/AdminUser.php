<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: AdminUser
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class AdminUser extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table admin_user
     */
    public $id = null;

    /**
     * @var string
     * @table admin_user
     */
    public $name = '';

    /**
     * @var string
     * @table admin_user
     */
    public $nickname = '';

    /**
     * @var string
     * @table admin_user
     */
    public $salt = '';

    /**
     * @var string
     * @table admin_user
     */
    public $passwd = '';

    /**
     * @var integer
     * @table admin_user
     */
    public $position_id = '0';

    /**
     * @var string
     * @table admin_user
     */
    public $avatar = null;

    /**
     * @var string
     * @table admin_user
     */
    public $mail = null;

    /**
     * @var unknown
     * @table admin_user
     */
    public $ctime = null;

    /**
     * @var unknown
     * @table admin_user
     */
    public $mtime = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->name = '';
        $this->nickname = '';
        $this->salt = '';
        $this->passwd = '';
        $this->positionId = '0';
        $this->avatar = NULL;
        $this->mail = NULL;
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
            'name' => 'name', 
            'nickname' => 'nickname', 
            'salt' => 'salt', 
            'passwd' => 'passwd', 
            'position_id' => 'positionId', 
            'avatar' => 'avatar', 
            'mail' => 'mail', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    public function initialize()
    {
        parent::initialize();
        $this->setWriteConnectionService("dbDemo");
        $this->setReadConnectionService("dbDemo_r");
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'admin_user';
    }


}

