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
        "url" => "http//shopbigbang.com",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ),
    'dbDemo' => array(
        "host" => "rds2yafurnqibun.mysql.rds.aliyuncs.com",
        "port" => 3306,
        "username" => "shbb",
        "password" => getenv("PHP_MYSQL_PASSWD_SHBB"),
        "dbname" => "shopbigbang",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
    'demoServerUrl' => array(
        "http://10.144.14.81:8003",
        "http://10.161.41.106:8003",
    ),
    'debugRPC' => false,
);
