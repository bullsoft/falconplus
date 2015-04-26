<?php
namespace Demo\Server\Services;
use Common\Protos\RequestDemo;
use Common\Protos\ResponseDemo;

class DemoService extends \PhalconPlus\Base\Service
{
    public function demo(RequestDemo $request)
    {
        $response = new ResponseDemo();
        error_log("Service get input: " . var_export($request, true));
        error_log("Server application name: " . $this->config->application->name);

        $result = "";
        
        if(isset($request->user) && $request->getUser()) {
            $result .= "Hi, " . ucfirst($request->getUser()->getUsername()) . ": ";
            if(isset($request->getUser()->status) && $request->getUser()->getStatus() != null) {
                $result .= ", Your status is " . $request->getUser()->getStatus() . " and ";
            }
        }
        
        $result .= $request->getFoo() . " + " . $request->getBar();
        
        $response->setResult($result);
        
        return $response;
    }

    public function simple(\PhalconPlus\Base\SimpleRequest $request)
    {
        return $request->getParam(2);
    }
        
}

