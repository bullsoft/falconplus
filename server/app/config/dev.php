<?php
return [
    'application' => [
        "name"  => "demoServerDev",
        "ns"    => "Demo\\Server\\",
        "mode"  => "Srv",
        "dbSplitRW" => true,
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
    'dbDemo_r' => [
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "123456",
        "dbname" => "p2p",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ],
    'dbCommon' => [
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "123456",
        "dbname" => "common",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 32768,
        'db'   => 1,
        'timeout' => 1,
    ],
];