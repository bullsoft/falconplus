<?php
ini_set("memory_limit", "4G");

if(count($argv) < 3) {
    echo <<<EOT
命令格式: php init.php module task action param1 param2 ...
- module 表示模块名称，即模块的目录名，如: /path/to/falcon/demo，此处就是demo
- task 表示任务名称，如：ModelTask，此处就是model
- action 表示具体执行的某个方法，如: main
- parma1, param2, ... main方法的入参
EOT;
    exit(1);
}

$script = array_shift($argv);
$module = array_shift($argv);

array_unshift($argv, $script);

$bootstrap = new \PhalconPlus\Bootstrap(dirname(dirname(__DIR__)) . "/" . $module);

$di = new \Phalcon\DI\FactoryDefault\CLI();
$di->set("dispatched", function() {
    return true;
});

$loader = new \Phalcon\Loader();
$loader->registerDirs(array(
    __DIR__."/tasks/",
))->register();

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
