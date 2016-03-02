<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: DealRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2016-02-27 19:22:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealRecord extends \PhalconPlus\Base\Model
{

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
    public $buyer_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $seller_id = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $amount = null;

    /**
     * @var integer
     * @table deal_record
     */
    public $status = null;

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
        $this->dealId = NULL;
        $this->buyerId = NULL;
        $this->sellerId = NULL;
        $this->amount = NULL;
        $this->status = NULL;
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
            'buyer_id' => 'buyerId', 
            'seller_id' => 'sellerId', 
            'amount' => 'amount', 
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
        return 'deal_record';
    }


}

