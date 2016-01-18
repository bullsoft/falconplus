<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: PaySp
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-01-12 17:30:52$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class PaySp extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table pay_sp
     */
    public $id = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $name = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $code = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $logo_url = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $website = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $ak = null;

    /**
     * @var integer
     * @table pay_sp
     */
    public $sk = null;

    /**
     * When an instance created, it would be executed
     */
    public function onConstruct()
    {
        $this->id = NULL;
        $this->name = NULL;
        $this->code = NULL;
        $this->logoUrl = NULL;
        $this->website = NULL;
        $this->ak = NULL;
        $this->sk = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'name' => 'name', 
            'code' => 'code', 
            'logo_url' => 'logoUrl', 
            'website' => 'website', 
            'ak' => 'ak', 
            'sk' => 'sk', 
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
        return 'pay_sp';
    }


}

