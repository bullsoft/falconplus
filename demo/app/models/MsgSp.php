<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: MsgSp
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2016-02-27 19:22:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class MsgSp extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table msg_sp
     */
    public $id = null;

    /**
     * @var integer
     * @table msg_sp
     */
    public $name = null;

    /**
     * @var integer
     * @table msg_sp
     */
    public $url = null;

    /**
     * @var integer
     * @table msg_sp
     */
    public $user = null;

    /**
     * @var integer
     * @table msg_sp
     */
    public $passwd = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->name = NULL;
        $this->url = NULL;
        $this->user = NULL;
        $this->passwd = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'url' => 'url', 
            'user' => 'user', 
            'passwd' => 'passwd', 
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
        return 'msg_sp';
    }


}

