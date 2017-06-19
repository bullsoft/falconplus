<?php
include __DIR__ . "/init.php";

use Zend\Code\Reflection\FileReflection;
use Zend\Code\Reflection\ClassReflection;

// 模块服务类路径
$dir = APP_MODULE_DIR . "/app/services/";

// 模块服务层命名空间
$namespace = $config->application->ns . "Services\\";

// 服务列表
$serviceFileList = glob($dir . '*Service.php');

$targetService = '';
if (array_key_exists('service', $_GET)) {
    $targetService = $_GET['service'];
}

// 手贱，如果在URL上拼错了Service名称
if (!empty($targetService) && !file_exists($dir.$targetService.".php")) {
    header("location: service.php");
    exit(0);
}

$indent = "    ";

if($targetService) {
    // 完整类名
    $serviceWithNamespace = $namespace . $targetService;

    $view->setVar("targetService", $targetService);
    $view->setVar("serviceWithNamespace", $serviceWithNamespace);


    // 文件反射 - Zend库独有
    $fileReflection = new FileReflection($dir . $targetService.".php", true);
    // 命名空间别名
    $uses = array();
    foreach ($fileReflection->getUses() as $use) {
        $as = $use["as"];
        if($as == null) {
            $as = substr(strrchr($use["use"], "\\"), 1);
        }
        $uses[$as] = $use["use"];
    }
    // 类反射 - 不陌生吧?
    $classReflection = new ClassReflection(new $serviceWithNamespace($di));

    $view->setVar("class", $classReflection);
    $view->setVar("file", $fileReflection);

    $methods = array();
    foreach ($classReflection->getMethods() as $k => $method) {
        // 以__开头的和非Public的方法都不予展现
        if (substr($method->getName(), 0, 2) == '__') {continue;}
        if (!$method->isPublic()) {continue;}

        // 加入方法名
        $methods[$k]['name'] = $method->getName();
        $methods[$k]['docComment'] = $indent . $method->getDocComment();
        $prototype = $method->getPrototype();
        $methodReturn = $prototype["return"];
        if(isset($uses[$methodReturn])) {
            $prototype["return"] = $uses[$methodReturn];
        }
        $methods[$k]["prototype"] = $prototype;

        $requestPrototype = reset($prototype["arguments"]);
        $paramClass = $requestPrototype["type"];

        $sampleCodes = "Sorry, no codes here now.";
        
        if(class_exists($paramClass)) {
            $sampleCodes = <<<EOT
<?php
// ... 此处省略若干框架启动代码
// ...
// 实例化Request
\$request = new {$paramClass}();

// 构造合法的Request
\$request
EOT;
            $reflectionParam = new \ReflectionClass($paramClass);
            $sampleSetter = [];
            foreach ($reflectionParam->getProperties() as $prop) {
                $sampleSetter[] = 'set'.ucfirst($prop->name)."(\${$prop->name})";
            }
            $sampleCodes .= '->'.implode("\n->", $sampleSetter) . ";";
            $srvName = substr($targetService, 0 ,-7);
            $sampleCodes .= "

// 发起RPC请求，并获得Response
// \$this->sa 为注入DI的Service Agent
\$response = \$this->rpc->callByObject(array(
        'service' => '{$srvName}',
        'method' => '{$method->name}',
        'args' => \$request,
));

// Response可以轻松转成数组
// \$response->toArray()
";
        }
        $methods[$k]['sampleCode'] = $sampleCodes;
    }
    $view->setVar('methods', $methods);
}

// 设置模板变量
$view->setVar("title", "Backend As A Service");
$view->setVar("welcome", "Welcome to " . $config->application->name . " service list !");
$view->setVar("serviceFileList", $serviceFileList);

$viewPage = pathinfo(__FILE__, PATHINFO_FILENAME);
$view->start()
     ->render("view", $viewPage)
     ->finish();
echo $view->getContent();
