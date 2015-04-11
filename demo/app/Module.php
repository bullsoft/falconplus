<?php
namespace Demo\Web;

use PhalconPlus\Base\AbstractModule as PlusModule;

class Module extends PlusModule
{
    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            __NAMESPACE__.'\\Controllers' => __DIR__.'/controllers/',
            __NAMESPACE__.'\\Models'      => __DIR__.'/models/',
            "Demo\\Protos"                => APP_ROOT_COMMON_DIR.'/protos/',
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

        // register a dispatcher
        $di->has("dispatched") || $di->set('dispatcher', function () use ($di) {
            $evtManager = $di->getShared('eventsManager');
            $evtManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(array(
                            'controller' => 'error',
                            'action'     => 'show404'
                        ));
                        return false;
                }
            });
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($evtManager);
            $dispatcher->setDefaultNamespace(__NAMESPACE__."\\Controllers\\");
            return $dispatcher;
        });
        
        // register db service 
        $di->setShared('dbDemo', function() use ($di) {
            $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
            return $mysql->getConnection();
        });

        $di->set("rpc", function() use ($di, $config, $bootstrap) {
            $client = null;
            if($config->debugRPC == true) {
                $bootstrap->dependModule("server");
                $client = new \PhalconPlus\RPC\Client\Adapter\Local($di);
            } else {
                $remoteUrls = $config->demoServerUrl;
                $client = new \PhalconPlus\RPC\Client\Adapter\Remote($remoteUrls->toArray());
                $client->SetOpt(\YAR_OPT_CONNECT_TIMEOUT, 5);
            }
            return $client;
        });
        
        // set view with volt
        $di->set('view', function() use ($di) {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(__DIR__.'/views/');
            $view->registerEngines(array(
                ".volt" => function($view, $di) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $volt->setOptions(array(
                        "compiledPath"      => $di->get('config')->view->compiledPath,
                        "compiledExtension" => $di->get('config')->view->compiledExtension,
                    ));
                    $compiler = $volt->getCompiler();
                    $compiler->addExtension(new \PhalconPlus\Volt\Extension\PhpFunction());
                    return $volt;
                }
            ));
            return $view;
        });
    }
}