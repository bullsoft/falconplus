<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealMoney
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-10 18:02:33$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealMoney extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table deal_money
     */
    public $id = null;

    /**
     * @var integer
     * @table deal_money
     */
    public $user_id = null;

    /**
     * @var integer
     * @table deal_money
     */
    public $available = null;

    /**
     * @var integer
     * @table deal_money
     */
    public $freeze = null;

    /**
     * @var unknown
     * @table deal_money
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var unknown
     * @table deal_money
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
        $this->available = NULL;
        $this->freeze = NULL;
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
            'available' => 'available', 
            'freeze' => 'freeze', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'deal_money';
    }


}

