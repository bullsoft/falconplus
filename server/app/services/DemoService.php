<?php
namespace Demo\Server\Services;
use Common\Protos\RequestDemo;
use Common\Protos\ResponseDemo;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;

/**
 * Class DemoService
 * @package Demo\Server\Services
 */
class DemoService extends \PhalconPlus\Base\Service
{
    /**
     * @param RequestDemo $request
     * @return ResponseDemo
     */
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

    /**
     * @param SimpleRequest $request
     * @return mixed
     */
    public function simple(SimpleRequest $request)
    {
        return $request->getParam(2);
    }
        
}

