<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: MailTemplate
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-16 17:37:15$
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
        $this->setWriteConnectionService("dbDemo");
        $this->setReadConnectionService("dbDemo_r");
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'mail_template';
    }


}

