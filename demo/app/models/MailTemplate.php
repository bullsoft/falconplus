<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: MailTemplate
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2016-02-27 19:22:01$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class MailTemplate extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table mail_template
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
        return 'mail_template';
    }


}

