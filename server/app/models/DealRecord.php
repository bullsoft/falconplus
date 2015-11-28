<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2015-10-25 18:26:30$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealRecord extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table deal_record
     */
    public $id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $deal_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $investor_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $borrower_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $amount = null;

    /**
     * @var unknown
     * @table deal_record
     */
    public $ctime = null;

    /**
     * @var datetime
     * @table deal_record
     */
    public $mtime = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->dealId = NULL;
        $this->investorId = NULL;
        $this->borrowerId = NULL;
        $this->amount = NULL;
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
            'deal_id' => 'dealId', 
            'investor_id' => 'investorId', 
            'borrower_id' => 'borrowerId', 
            'amount' => 'amount', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
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
        return 'deal_record';
    }


}

