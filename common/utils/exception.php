<?php
require dirname(__DIR__) . "/protos/EnumExceptionCode.php";
require dirname(__DIR__) . "/protos/EnumLoggerLevel.php";

use Demo\Protos\EnumExceptionCode as EnumExceptionCode;

$enumExceptionCode = EnumExceptionCode::validValues(true);
$exceptionNS = EnumExceptionCode::exceptionClassPrefix();

$dir = dirname(__DIR__) . "/protos/Exception/";

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
    
    $eCode = new EnumExceptionCode($code);
    $replacement["message"] = var_export($eCode->getMessage(), true);
    $replacement["level"] = $eCode->getLevel();
    
    $class = "<?php\n" . str_replace($tokens, $replacement, $classTemplate);
    $filePath = $dir . $replacement["className"] . ".php";
    
    file_put_contents($filePath, $class);
    
    echo "\t...\t\33[1;32mFinish\33[m" . PHP_EOL ;
    
}
