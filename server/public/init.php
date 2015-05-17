<?php
$bootstrap = new \PhalconPlus\Bootstrap(dirname(__DIR__));
$bootstrap->execSrv(false);
$di = $bootstrap->getDI();
$config = $bootstrap->getConfig();

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    "Zend" => APP_ROOT_COMMON_DIR . "vendor/Zend/",
))->register();

// 初始化模板
$view = new \Phalcon\Mvc\View();
$view->setDI($di);
$view->setViewsDir(__DIR__."/assets/");
$view->registerEngines(array(
    ".volt" => function() use ($view, $di) {
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
        $volt->setOptions(array(
            "compiledPath"      => __DIR__."/assets/compiled/",
            "compiledExtension" => ".compiled",
            "compiledAlways"    => true
        ));
        $compiler = $volt->getCompiler();
        $compiler->addExtension(new \PhalconPlus\Volt\Extension\PhpFunction());
        return $volt;
    }
));
