<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealPayRecord
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-12 17:30:52$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealPayRecord extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table deal_pay_record
     */
    public $id = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
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
        return 'deal_pay_record';
    }


}

