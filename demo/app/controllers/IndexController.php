<?php
namespace Demo\Web\Controllers;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->setVar("hello", "hello, world! ");
        $this->view->setVar("world", array("foo" => "bar"));
    }
}