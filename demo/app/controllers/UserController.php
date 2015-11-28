<?php
namespace Demo\Web\Controllers;

use \PhalconPlus\Base\SimpleRequest;

class UserController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $request = new SimpleRequest();
        $request->setParam("foo");
        $request->setParam("bar");
        $response = $this->ucRpc->callByObject(array(
            "service" => "\\UCenter\\Srv\\Services\\Dummy",
            "method" => "demo",
            "args" => $request,
        ));

        var_dump($response);
    }

    public function dAction()
    {
        $this->session->destroy();
        echo "OK";
    }
}