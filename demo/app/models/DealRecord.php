<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: DealRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2015-04-20 15:09:04$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealRecord extends \PhalconPlus\Base\Model
{

    const OP_NONE = 0;

    const OP_CREATE = 1;

    const OP_UPDATE = 2;

    const OP_DELETE = 3;

    const DIRTY_STATE_PERSISTENT = 0;

    const DIRTY_STATE_TRANSIENT = 1;

    const DIRTY_STATE_DETACHED = 2;

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
     * @var date
     * @table deal_record
     */
    public $ctime = '0000-00-00 00:00:00';

    /**
     * @var date
     * @table deal_record
     */
    public $mtime = '0000-00-00 00:00:00';

    public function initialize()
    {
        parent::initialize();
        $this->setConnectionService("dbDemo");
    }

    /**
     * Set the baz property
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->dealId = NULL;
        $this->investorId = NULL;
        $this->borrowerId = NULL;
        $this->amount = NULL;
        $this->ctime = '0000-00-00 00:00:00';
        $this->mtime = '0000-00-00 00:00:00';
    }

    /**
     * Set the baz property
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

    /**
     * 返回模型对应的表名
     */
    public function getSource()
    {
        return 'deal_record';
    }


}

