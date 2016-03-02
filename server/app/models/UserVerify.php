<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: UserVerify
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-03-02 19:02:14$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class UserVerify extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table user_verify
     */
    public $id = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $user_id = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $realname = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $sex = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $birthday = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $home_addr = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $id_card = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $id_avatar = null;

    /**
     * @var integer
     * @table user_verify
     */
    public $intro = null;

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
        $this->realname = NULL;
        $this->sex = NULL;
        $this->birthday = NULL;
        $this->homeAddr = NULL;
        $this->idCard = NULL;
        $this->idAvatar = NULL;
        $this->intro = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'user_id' => 'userId', 
            'realname' => 'realname', 
            'sex' => 'sex', 
            'birthday' => 'birthday', 
            'home_addr' => 'homeAddr', 
            'id_card' => 'idCard', 
            'id_avatar' => 'idAvatar', 
            'intro' => 'intro', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'user_verify';
    }


}

