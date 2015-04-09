<?php
/* Code: */

use Phalcon\Logger\Adapter\File as FileLogger;

mb_internal_encoding("UTF-8");

// register global class-dirs, class-namespace and class-prefix
// $loader->registerDirs(array())->register();

$loader->registerNamespaces($config->namespace->toArray())->register();

// class autoloader
$di->setShared('loader', function () use ($loader) {
    return $loader;
});

// global config
$di->set('config', function () use ($config) {
    return $config;
});

// global logger
$di->set('logger', function () use ($config) {
    try {
        $logger = new FileLogger($config->application->logFilePath);
        return $logger;
    } catch (\Exception $e) {
        throw $e;
    }
}, true);

$di->setShared('modelsManager', function() {
    return new \Phalcon\Mvc\Model\Manager();
});

// global funciton to retrive $di
if (!function_exists("getDI")) {
    function getDI()
    {
        return \Phalcon\DI::getDefault();
    }
}

/* default.php ends here */
