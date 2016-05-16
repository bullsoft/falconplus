<?php

namespace Plus\Web\Controllers;

class ManualController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $markdown = new \ParsedownExtra();
        echo $markdown->text('# Manual {.sth}'); # prints: <h1 class="sth">Header</h1>
        echo $markdown->text('`TBD.`');
    }
}