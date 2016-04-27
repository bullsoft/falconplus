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
            __NAMESPACE__."\\Plugins"  => __DIR__.'/plugins/',
            __NAMESPACE__."\\Daos"     => __DIR__.'/daos/',
            "Common\\Protos"           => APP_ROOT_COMMON_DIR.'/protos/',
            "Zend"                     => APP_ROOT_COMMON_DIR.'/vendor/Zend/',
            "BullSoft"                 => APP_ROOT_COMMON_DIR . "/vendor/BullSoft/"

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

        $di->setShared("profiler", function(){
            $profiler = new \Phalcon\Db\Profiler();
            return $profiler;
        });

        // register db service 
        $di->setShared('dbDemo', function() use ($di) {
            $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
            $db = $mysql->getConnection();
            $profiler = $di->get("profiler");
            $logger = $di->get("logger");
            $evtManager = $di->getShared("eventsManager");
            $evtManager->attach('db', function ($event, $connection) use ($profiler) {
                if ($event->getType() == 'beforeQuery') {
                    $sql = getRealSql($connection); // function getRealSql() is defined in common/load/default.php
                    $profiler->startProfile($sql);
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            });
            // Assign the eventsManager to the db adapter instance
            $db->setEventsManager($evtManager);
            return $db;
        });

        // register db service 
        $di->setShared('r_dbDemo', function() use ($di) {
            $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
            $db = $mysql->getConnection();
            $profiler = $di->get("profiler");
            $logger = $di->get("logger");
            $evtManager = $di->getShared("eventsManager");
            $evtManager->attach('db', function ($event, $connection) use ($profiler) {
                if ($event->getType() == 'beforeQuery') {
                    $sql = getRealSql($connection); // function getRealSql() is defined in common/load/default.php
                    $profiler->startProfile($sql);
                }
                if ($event->getType() == 'afterQuery') {
                    $profiler->stopProfile();
                }
            });
            // Assign the eventsManager to the db adapter instance
            $db->setEventsManager($evtManager);
            return $db;
        });

        $di->set("serviceListener", function() use ($di) {
            $evtManager = $di->getShared("eventsManager");
            $rpcListener = new \Demo\Server\Plugins\RpcListener($this->di, $evtManager);
            $evtManager->attach("backend-server", $rpcListener);
        });

        $di->setShared("redis", function(){
            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            return $redis;
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
