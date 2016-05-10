<?php
namespace Demo\Web;

use PhalconPlus\Base\AbstractModule as PlusModule;
use PhalconPlus\Logger\Processor\Trace as TraceProcessor;
use PhalconPlus\Logger\Processor\Uid as UidProcessor;

class Module extends PlusModule
{
    public function __construct(\Phalcon\DI $di)
    {
        parent::__construct($di);
        if(APP_ENV != "dev") {
            set_exception_handler(function ($exception) use ($di) {
                $response = $di->get("response");
                $msg = $exception->getMessage();
                $data = new \stdClass();
                if (substr($msg, 0, 8) == "__DATA__") {
                    $msg = substr($msg, 8);
                    $data = json_decode($msg, true);
                    $msgs = [];
                    foreach ($data as $item) {
                        $msgs[] = implode(",", $item);
                    }
                    $msg = implode(";", $msgs);
                }
                $error = array(
                    'errorCode' => max(1, $exception->getCode()),
                    'errorMsg' => $msg,
                    'data' => $data,
                    'sessionId' => '',
                );
                $response->setHeader('Content-Type', 'application/json');
                $response->setJsonContent($error);
                $response->send();
            });
        }
    }

    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            __NAMESPACE__.'\\Controllers'       => __DIR__.'/controllers/',
            __NAMESPACE__.'\\Models'            => __DIR__.'/models/',
            __NAMESPACE__."\\Plugins"           => __DIR__.'/plugins/',
            "Detection"                         => APP_ROOT_COMMON_DIR . "/vendor/Mobile-Detect/namespaced/Detection/",
            "Zend"                              => APP_ROOT_COMMON_DIR . "/vendor/Zend/",
            "Common\\Protos"                    => APP_ROOT_COMMON_DIR . "/protos/",
            "BullSoft"                          => APP_ROOT_COMMON_DIR . "/vendor/BullSoft/",
            __NAMESPACE__.'\\Controllers\\Apis' => __DIR__.'/controllers/apis/',
        ))->register();

        // load composer library
        require_once APP_ROOT_COMMON_DIR . "/vendor/vendor/autoload.php";
    }

    public function registerServices()
    {
        // get di
        $di = $this->di;
        // get bootstrap obj
        $bootstrap = $di->get('bootstrap');
        // get config
        $config = $di->get('config');

        $router = $di->getShared("router");
        if($router instanceof \Phalcon\Mvc\Router) {
            $router->add('/apis/:controller/([a-zA-Z0-9_\-]+)/:params', array(
                'controller' => 1,
                'action'     => 2,
                'params'     => 3,
                'namespace'  => __NAMESPACE__ . "\\Controllers\\Apis",
            ))->convert('action', function ($action) {
                // transform action from foo-bar -> foo_bar
                $a = str_replace('-', '_', $action);
                // transform action from foo_bar -> fooBar
                return lcfirst(\Phalcon\Text::camelize($a));
            });
        }

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
                    default:
                        throw $exception;
                }
            });

            $interceptor = new \Demo\Web\Plugins\DispatcherInterceptor($di, $evtManager);
            $evtManager->attach('dispatch', $interceptor);

            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($evtManager);
            $dispatcher->setDefaultNamespace(__NAMESPACE__."\\Controllers\\");
            return $dispatcher;
        });

        $di->setShared('siteConf', function() {
            $siteConfs = include_once(APP_MODULE_DIR . "app/config/siteTitle.php");
            return new \Phalcon\Config($siteConfs);
        });

        $di->set('profiler', function(){
            return new \Phalcon\Db\Profiler();
        }, true);

        // register db service
        $di->setShared('dbDemo', function() use ($di) {
            $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
            $connection = $mysql->getConnection();

            $eventsManager = new \Phalcon\Events\Manager();
            $profiler = $di->getProfiler();
            $eventsManager->attach('db', function($event, $connection) use ($profiler) {
                if ($event->getType() == 'beforeQuery') {
                    $profiler->startProfile($connection->getSQLStatement());
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            });
            $connection->setEventsManager($eventsManager);
            return $connection;
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
                // $client->SetOpt(\CURLOPT_NOSIGNAL, 1);
            }
            return $client;
        });

        $di->set("ucRpc", function() use ($di, $config, $bootstrap) {
            $client = null;
            if($config->debugRPC == true) {
                $bootstrap->dependModule("ucenter");
                $client = new \PhalconPlus\RPC\Client\Adapter\Local($di);
            } else {
                $remoteUrls = $config->uCenterServerUrl;
                $client = new \PhalconPlus\RPC\Client\Adapter\Remote($remoteUrls->toArray());
                $client->SetOpt(\YAR_OPT_CONNECT_TIMEOUT, 5);
                $client->SetOpt(\CURLOPT_NOSIGNAL, 1);
            }
            return $client;
        });

        // set view with volt
        $di->set('view', function() use ($di) {
            $tpl = $di->get("siteConf")->template;
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(__DIR__."/views/{$tpl}/");
            $view->registerEngines(array(
                ".volt" => function($view, $di) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                    $volt->setOptions(array(
                        "compiledPath"      => $di->get('config')->view->compiledPath,
                        "compiledExtension" => $di->get('config')->view->compiledExtension,
                        "compiledSeparator" => "_",
                        // in dev only
                        "compileAlways"     => true,
                    ));
                    // 如果模板缓存目录不存在，则创建它
                    if(!file_exists($di->get('config')->view->compiledPath)) {
                        mkdir($di->get('config')->view->compiledPath, 0777, true);
                    }
                    $compiler = $volt->getCompiler();
                    $ext = new \PhalconPlus\Volt\Extension\PhpFunction();
<<<<<<< HEAD
                    $ext->setCustNamespace('\Demo\Web\Plugins\\');
=======
                    $ext->setCustNamespace(__NAMESPACE__ . "\\Plugins\\");
                    // $ext->setCustFuncName("haha");
>>>>>>> 5b06741847dada6e462ec55f0b49305b9ab68819
                    $compiler->addExtension($ext);
                    return $volt;
                }
            ));
            return $view;
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

        $di->set("requestCheck", function($serivce, $method) {
            error_log("Service::Method: ". $serivce . "::" . $method);
        });

        $di->set("url", function(){
            $url = new \Phalcon\Mvc\Url();
            // Dynamic URIs are
            $url->setBaseUri('/');
            // Static resources go through a CDN
            $url->setStaticBaseUri('http://static.mywebsite.com/');
            return $url;
        });
    }
}
