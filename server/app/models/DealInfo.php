<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: DealInfo
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-12 17:30:52$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class DealInfo extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table deal_info
     */
    public $id = null;

    /**
     * @var integer
     * @table deal_info
     */
    public $name = null;

    /**
     * @var integer
     * @table deal_info
     */
    public $price = null;

    /**
     * @var integer
     * @table deal_info
     */
    public $borrower_id = null;

    /**
     * @var integer
     * @table deal_info
     */
    public $intro = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->name = NULL;
        $this->price = NULL;
        $this->borrowerId = NULL;
        $this->intro = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'price' => 'price', 
            'borrower_id' => 'borrowerId', 
            'intro' => 'intro', 
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
        return 'deal_info';
    }


}

