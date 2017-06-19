<?php

namespace Plus\Web\Controllers;

class ManualController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $markdown = new \ParsedownExtra();
        $str = file_get_contents(APP_MODULE_DIR."public/manual.md");
        echo $markdown->text($str);
        // echo $markdown->text('`TBD.`');
    }
}