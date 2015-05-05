<?php
namespace Demo\Server;

use PhalconPlus\Base\AbstractModule as PlusModule;
use PhalconPlus\Logger\Processor\Trace as TraceProcessor;
use PhalconPlus\Logger\Processor\Uid as UidProcessor;

class Srv extends PlusModule
{
    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            __NAMESPACE__.'\\Services' => __DIR__.'/services/',
            __NAMESPACE__.'\\Models'   => __DIR__.'/models/',
            "Common\\Protos"             => APP_ROOT_COMMON_DIR.'/protos/',
        ))->register();
    }
    
    public function registerServices()
    {
        // get di
        $di = $this->di;
        // get bootstrap obj
        $bootstrap = $di->get('bootstrap');
        // get config
        $config = $di->get('config');
        
        // register db service 
        $di->setShared('dbDemo', function() use ($di) {
            $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
            return $mysql->getConnection();
        });

        $di->set("requestCheck", function($serivce, $method, $request) use ($di, $config) {
            error_log("Request Check: " . $serivce . ":" . $method . "::::" . var_export($request, true));
        });

        $di->setShared("logger", function() use ($di, $config){
            $logger = new \PhalconPlus\Logger\Adapter\FilePlus($config->application->logFilePath);
            $logger->registerExtension(".de", [\Phalcon\Logger::DEBUG]);
            // 添加formatter
            $formatter = new \PhalconPlus\Logger\Formatter\LinePlus("[%date%][%trace%][%uid%][%type%] %message%");
            $formatter->addProcessor("uid", new UidProcessor(18));
            $formatter->addProcessor("trace", new TraceProcessor(TraceProcessor::T_CLASS));
            
            $logger->setFormatter($formatter);
            return $logger;
        });
    }
}
