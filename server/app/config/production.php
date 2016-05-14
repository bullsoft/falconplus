<?php
return array(
    'application' => array(
        "name"  => "demoServerProduction",
        "ns"    => "Demo\\Server\\",
        "mode"  => "Srv",
        "staticUri" => "/",
        "url" => "http//server.phalconphp.org/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ),
    'dbDemo' => array(
        "host" => "rds2yafurnqibun.mysql.rds.aliyuncs.com",
        "port" => 3306,
        "username" => getenv("PHP_MYSQL_USER_SHBB"),
        "password" => getenv("PHP_MYSQL_PASSWD_SHBB"),
        "dbname" => "shopbigbang",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
    'dbDemo_r' => array(
        "host" => "rds2yafurnqibun.mysql.rds.aliyuncs.com",
        "port" => 3306,
        "username" => getenv("PHP_MYSQL_USER_SHBB"),
        "password" => getenv("PHP_MYSQL_PASSWD_SHBB"),
        "dbname" => "shopbigbang",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
);
