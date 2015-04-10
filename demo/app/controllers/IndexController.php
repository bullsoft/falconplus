<?php
namespace Demo\Web\Controllers;

use Demo\Web\Models\DealRecord;

class IndexController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $this->view->setVar("hello", "hello, world! ");
        $this->view->setVar("world", array("foo" => "bar"));
    }

    public function dbAction()
    {
        // var_dump($this->di->get('dbDemo'));
        $a = DealRecord::find()->toArray();
        // var_dump($a);
        $b = DealRecord::getInstance()
           ->createBuilder("dr")
           ->columns("dr.dealId, dr.borrowerId")
           ->limit(1)
           ->getQuery()
           ->execute();
        
        var_dump($b->toArray());
    }
}