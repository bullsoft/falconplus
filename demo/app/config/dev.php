<?php
return array(
    "view" => array(
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
    'application' => array(
        "name"  => "demo-web",
        "ns"    => "Demo\\Web\\",
        "mode"  => "Web",
        "staticUri" => "/",
        "url" => "http://127.0.0.1:8084/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ),
    'dbDemo' => array(
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "p2p",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
        "retryInterval" => 200000, // 失败重试间隔200ms
        "retryTimes" => 5, //失败重试次数
    ),
    'demoServerUrl' => array(
        "http://127.0.0.1:8083/",
        "http://127.0.0.1:8083/",
    ),
    'debugRPC' => false,
    'uCenterServerUrl' => array(
        "http://ucenter.phalconplus.com",
    ),
);
