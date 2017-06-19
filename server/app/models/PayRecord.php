<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: PayRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class PayRecord extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table pay_record
     */
    public $id = null;

    /**
     * @var integer
     * @table pay_record
     */
    public $user_id = null;

    /**
     * @var integer
     * @table pay_record
     */
    public $deal_id = null;

    /**
     * @var integer
     * @table pay_record
     */
    public $amount = null;

    /**
     * @var integer
     * @table pay_record
     */
    public $pay_sp_id = null;

    /**
     * @var integer
     * @table pay_record
     */
    public $status = '0';

    /**
     * @var unknown
     * @table pay_record
     */
    public $ctime = null;

    /**
     * @var unknown
     * @table pay_record
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
        $this->userId = NULL;
        $this->dealId = NULL;
        $this->amount = NULL;
        $this->paySpId = NULL;
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
            'user_id' => 'userId', 
            'deal_id' => 'dealId', 
            'amount' => 'amount', 
            'pay_sp_id' => 'paySpId', 
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
        return 'pay_record';
    }


}

