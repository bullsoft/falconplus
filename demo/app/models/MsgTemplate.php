<?php

namespace Demo\Web\Models;

/**
 * Phalcon Model: MsgTemplate
 *
 * 此文件由代码自动生成，代码依赖PhalconPlus和Zend\Code\Generator
 *
 * @namespace Demo\Web\Models
 * @version $Rev:2016-02-27 19:22:01$
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
        return 'msg_template';
    }


}

