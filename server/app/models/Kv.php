<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: Kv
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2015-10-25 18:26:31$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class Kv extends \PhalconPlus\Base\Model
{
    static $shardKey;
    
    /**
     * @var integer
     * @table kv
     */
    public $id = null;

    public $user_id = null;
    /**
     * @var string
     * @table kv
     */
    public $key = null;

    /**
     * @var string
     * @table kv
     */
    public $val = null;

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
        $this->key = NULL;
        $this->val = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'user_id' => 'userId',
            'key' => 'key', 
            'val' => 'val',
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'kv_'. (self::$shardKey % 2);
    }
}

