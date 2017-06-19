<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: PaySp
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-08-09 11:43:01$
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
     * @var string
     * @table pay_sp
     */
    public $name = '';

    /**
     * @var string
     * @table pay_sp
     */
    public $code = '';

    /**
     * @var string
     * @table pay_sp
     */
    public $logo_url = '';

    /**
     * @var string
     * @table pay_sp
     */
    public $website = null;

    /**
     * @var string
     * @table pay_sp
     */
    public $partner_id = null;

    /**
     * @var string
     * @table pay_sp
     */
    public $ak = null;

    /**
     * @var string
     * @table pay_sp
     */
    public $sk = null;

    /**
     * @var unknown
     * @table pay_sp
     */
    public $ctime = null;

    /**
     * @var unknown
     * @table pay_sp
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
        $this->name = '';
        $this->code = '';
        $this->logoUrl = '';
        $this->website = NULL;
        $this->partnerId = NULL;
        $this->ak = NULL;
        $this->sk = NULL;
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
            'name' => 'name', 
            'code' => 'code', 
            'logo_url' => 'logoUrl', 
            'website' => 'website', 
            'partner_id' => 'partnerId', 
            'ak' => 'ak', 
            'sk' => 'sk', 
            'ctime' => 'ctime', 
            'mtime' => 'mtime', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'pay_sp';
    }


}

