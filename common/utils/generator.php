<?php
define("APP_ROOT_DIR", dirname(dirname(__DIR__)) . "/");

define("APP_ROOT_COMMON_DIR", APP_ROOT_DIR . "/common/");

if (count($argv) < 4) {
	echo <<<EOT
用法：php generator.php namespace(根命名空间) module(模块名称) mode(运行模式)

运行模式可选值为: 
 - Web: 常用于API和Frontend
 - Cli: 常用于任务
 - Srv: 常用于服务

EOT;
	exit(1);
}

$modeMap = array(
	"Web" => "Module",
	"Cli" => "Task",
	"Srv" => "Srv",
);

$rootNs = ucfirst($argv[1]);
$module = $argv[2];
$mode = ucfirst(strtolower($argv[3]));

if(!isset($modeMap[$mode])) {
	echo "该模式({$mode})尚不支持";
	exit(1);
}

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    "Zend" => APP_ROOT_COMMON_DIR . "vendor/Zend/",
    "League\Flysystem" => APP_ROOT_COMMON_DIR . "vendor/Flysystem",
))->register();

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as LocalAdapter;

$filesystem = new Filesystem(new LocalAdapter(APP_ROOT_DIR));

if ($filesystem->has($module)) {
	echo "模块({$module})已经存在，请更换名称再试" . PHP_EOL;
	exit(1);
}

echo "正在为你生成 Phalcon+ 模块, 根命名空间: {$rootNs}, 模块名: {$module}, 运行模式：{$mode} ... " . PHP_EOL;


$dirs = array(
	"app/config",
	"public"
);

$files = array(
	"public/index.php",
	"app/config/dev.php",
	"app/" . $modeMap[$mode] . ".php",
);

if($mode == "Web") {
	$dirs[] = "app/controllers";
	$dirs[] = "app/views/index";
	$files[] = "app/controllers/IndexController.php";
	$files[] = "app/controllers/ErrorController.php";
} elseif ($mode == "Srv") {
	$dirs[] = "app/services";
	$dirs[] = "app/tasks";
	$dirs[] = "app/models";

	$files[] = "app/services/DummyService.php";
	$files[] = "app/tasks/init.php";
}

foreach ($dirs as $dir) {
	$filesystem->createDir($module."/".$dir);
}

$di = new \Phalcon\DI\FactoryDefault\CLI();

// 初始化模板
$view = new \Phalcon\Mvc\View();
$view->setDI($di);
$view->setViewsDir(__DIR__."/");
$view->registerEngines(array(
    ".volt" => function() use ($view, $di) {
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
        $volt->setOptions(array(
            "compiledPath"      => __DIR__."/generator/compiled/",
            "compiledExtension" => ".compiled",
            "compiledAlways"    => false
        ));
        $compiler = $volt->getCompiler();
        $compiler->addExtension(new \PhalconPlus\Volt\Extension\PhpFunction());
        return $volt;
    }
));

$filesystem->createDir("common/utils/generator/compiled");

// 生成文件
foreach ($files as $file) {
	$fileName = basename($file);
	// echo $fileName . PHP_EOL;
	$view->start()
	     ->render("generator", $fileName)
	     ->finish();

	$view->setVar("rootNs", $rootNs);
	$view->setVar("module", $module);
	$view->setVar("mode", $mode);
	$filesystem->write($module."/".$file, "<?php\n".$view->getContent());
}

$filesystem->deleteDir("common/utils/generator/compiled");

echo "Finish.";
