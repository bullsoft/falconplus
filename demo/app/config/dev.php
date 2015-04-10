<?php
return array(
    "view" => array(
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
    'application' => array(
        "name"  => "demo-web",
        "ns"    => "Demo\Web\\",
        "mode"  => "Web",
        "staticUri" => "/",
        "url" => "http//demo.phalconplus.com/",
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
    ),
    'demoServerUrl' => array(
        "http://server.phalconplus.com",
        "http://server.phalconplus.com",
        "http://server.phalconplus.com",
    ),
    'debugRPC' => false,
);
