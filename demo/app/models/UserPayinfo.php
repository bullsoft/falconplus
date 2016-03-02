<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: UserPayinfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2016-02-27 19:22:02$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class UserPayinfo extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table user_payinfo
     */
    public $id = null;

    /**
     * @var integer
     * @table user_payinfo
     */
    public $user_id = null;

    /**
     * @var integer
     * @table user_payinfo
     */
    public $pay_sp_id = null;

    /**
     * @var integer
     * @table user_payinfo
     */
    public $account = null;

    /**
     * @var integer
     * @table user_payinfo
     */
    public $status = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->userId = NULL;
        $this->paySpId = NULL;
        $this->account = NULL;
        $this->status = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'user_id' => 'userId', 
            'pay_sp_id' => 'paySpId', 
            'account' => 'account', 
            'status' => 'status', 
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
        return 'user_payinfo';
    }


}
