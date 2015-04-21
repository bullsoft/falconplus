<?php

define("APP_ROOT_COMMON_DIR", dirname(dirname(__DIR__)) . "/common/");

$enumExceptionFilePath = APP_ROOT_COMMON_DIR . "protos/EnumExceptionCode.php";

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    "Zend" => APP_ROOT_COMMON_DIR . "vendor/Zend/",
))->register();

$fileReflector = new Zend\Code\Reflection\FileReflection($enumExceptionFilePath, true);
$ns = $fileReflector->getNamespace();

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    $ns => APP_ROOT_COMMON_DIR . "protos/"
))->register();

// 异常类名
$enumExceptionClass = $ns . "\\EnumExceptionCode";

$enumExceptionCode = $enumExceptionClass::validValues(true);
$exceptionNS = $enumExceptionClass::exceptionClassPrefix();

$dir = APP_ROOT_COMMON_DIR . "protos/Exception/";
 
$classTemplate = <<<'EOT'
namespace <<<namespace>>>;
/**
 * 此类由代码自动生成，请不要修改
 */
class <<<className>>> extends \PhalconPlus\Base\Exception
{
    protected $code = <<<code>>>;
    protected $message = <<<message>>>;
    protected $level = <<<level>>>;
}
EOT;

$tokens = array(
    "<<<namespace>>>",
    "<<<className>>>",
    "<<<code>>>" ,
    "<<<message>>>",
    "<<<level>>>",
);

foreach ($enumExceptionCode as $className => $code) {

    echo "Generate exception class for " . $className . " with code " . $code;
    
    $replacement = [];
    $replacement["namespace"] = rtrim($exceptionNS, "\\");
    $replacement["className"] = \Phalcon\Text::camelize($className);
    $replacement["code"] = $code;
    
    $eCode = new $enumExceptionClass($code);
    $replacement["message"] = var_export($eCode->getMessage()?:"未知错误", true);
    $replacement["level"] = $eCode->getLevel();
    
    $class = "<?php\n" . str_replace($tokens, $replacement, $classTemplate);
    $filePath = $dir . $replacement["className"] . ".php";
    
    file_put_contents($filePath, $class);
    
    echo "\t...\t\33[1;32mFinish\33[m" . PHP_EOL ;
    
}
