<?php
// initialize
include __DIR__ ."/init.php";

use Zend\Code\Reflection\FileReflection;
use Zend\Code\Reflection\ClassReflection;

$class = isset($_GET['class'])?$_GET['class']:"";
if(empty($class)) {
    echo "Nothing found here!";
    exit(1);
}

$class = str_replace("_", "\\", $class);

if(!class_exists($class)) {
    echo "Whoops, Class {$class} not exists!";
    exit(1);
}

$classReflection = new ClassReflection($class);
if($classReflection->isInternal()) {
    echo "Internal classes Cannot be readed.";
    exit(1);
}

$indent = "    ";

$consts = $classReflection->getConstants();

// 设置模板变量
$view->setVar('classReflection', $classReflection);
$view->setVar('consts', $consts);
$view->setVar("title", "RPC ProtoBuffer Specification");
$view->setVar('class', $class);

$parentClassReflection = $classReflection->getParentClass();
if($parentClassReflection) {
    $view->setVar("parentClass", $parentClassReflection->getName());
} else {
    $view->setVar("parentClass", false);
}

$properties = array();
foreach($classReflection->getProperties() as $k => $property) {
    $properties[] = $property;
}

$view->setVar("properties", $properties);

$methods = array();
foreach ($classReflection->getMethods() as $k => $method) {
    // 以__开头的和非Public的方法都不予展现
    if (substr($method->getName(), 0, 2) == '__') {
        continue;
    }
    if (!$method->isPublic()) {
        continue;
    }

    // 加入方法名
    $methods[$k]['name'] = $method->getName();
    $methods[$k]['docComment'] = $indent . $method->getDocComment();
    $prototype = $method->getPrototype();
    $methodReturn = $prototype["return"];
    if (isset($uses[$methodReturn])) {
        $prototype["return"] = $uses[$methodReturn];
    }
    $methods[$k]["prototype"] = $prototype;


}
$view->setVar('methods', $methods);

$viewPage = pathinfo(__FILE__, PATHINFO_FILENAME);
$view->start()
     ->render("view", $viewPage)
     ->finish();
echo $view->getContent();

?>
