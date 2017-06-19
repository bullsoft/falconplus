<?php
namespace Demo\Admin\Web\Controllers;

class BaseController extends \Phalcon\Mvc\Controller
{

    protected $jsFooter;

    /**
     * 模板使用示例
     */
    public function initialize()
    {
        $this->jsFooter = $this->assets->collection("js-footer");
    }
}