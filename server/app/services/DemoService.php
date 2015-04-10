<?php
namespace Demo\Server\Services;
use Demo\Protos\RequestDemo;
use Demo\Protos\ResponseDemo;

class DemoService extends \PhalconPlus\Base\Service
{
    public function demo(RequestDemo $request)
    {
        $response = new ResponseDemo();
        error_log("Service get input: " . var_export($request, true));
        $response->setResult($request->getFoo() . " + " . $request->getBar());
        return $response;
    }
}

