<?php

namespace Demo\Server\Models;

/**
 * Phalcon Model: MsgTemplate
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Server\Models
 * @version $Rev:2016-05-10 18:02:33$
 * @license PhalconPlus(http://plus.phalconphp.org/license-1.0.html)
 */
class MsgTemplate extends \PhalconPlus\Base\Model
{

    /**
     * @var integer
     * @table msg_template
     */
    public $id = null;

    /**
     * @var integer
     * @table msg_template
     */
    public $tpl = null;

    /**
     * @var integer
     * @table msg_template
     */
    public $comment = null;

    /**
     * @var integer
     * @table msg_template
     */
    public $user_id = null;

    /**
     * @var integer
     * @table msg_template
     */
    public $status = null;

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
        $this->tpl = NULL;
        $this->comment = NULL;
        $this->userId = NULL;
        $this->status = NULL;
    }

    /**
     * Column map for database fields and model properties
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'tpl' => 'tpl', 
            'comment' => 'comment', 
            'user_id' => 'userId', 
            'status' => 'status', 
        );
    }

    /**
     * return related table name
     */
    public function getSource()
    {
        return 'msg_template';
    }


}

