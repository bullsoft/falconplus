<?php
return [
    'application' => [
        "name"  => "demoServerDev",
        "ns"    => "Demo\\Server\\",
        "mode"  => "Srv",
        "staticUri" => "/",
        "url" => "http//server.phalconplus.com/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ],
    'dbDemo' => [
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "123456",
        "dbname" => "p2p",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 32678,
    ],
];