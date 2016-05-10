<?php
return array(
    'application' => array(
        "name"  => "demoServerDev",
        "ns"    => "Demo\\Server\\",
        "mode"  => "Srv",
        "staticUri" => "/",
        "url" => "http//server.phalconplus.com/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ),
    'dbDemo' => array(
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "123456",
        "dbname" => "p2p",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
);
