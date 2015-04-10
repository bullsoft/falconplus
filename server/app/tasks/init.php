<?php
ini_set("memory_limit", "4G");

$bootstrap = new \PhalconPlus\Bootstrap(dirname(dirname(__DIR__)));

$di = new \Phalcon\DI\FactoryDefault\CLI();
$di->set("dispatched", function() {
    return true;
});

$loader = new \Phalcon\Loader();
$loader->registerDirs(array(__DIR__))
       ->register();

$arguments = array();
foreach($argv as $k => $arg) {
    if($k == 1) {
        $arguments['task'] = $arg;
    } elseif($k == 2) {
        $arguments['action'] = $arg;
    } elseif($k >= 3) {
        $arguments['params'][] = $arg;
    }
}
$bootstrap->execTask($arguments, $di);
