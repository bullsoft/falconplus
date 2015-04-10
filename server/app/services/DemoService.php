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
        error_log("Server application name: " . $this->config->application->name);
        $response->setResult($request->getFoo() . " + " . $request->getBar());
        return $response;
    }
}

