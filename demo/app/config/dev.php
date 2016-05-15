<?php
return [
    "view" => [
        "extendedNs"        => "Plugins",
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ],
    'application' => [
        "name"  => "demo-web",
        "ns"    => "Demo\\Web\\",
        "mode"  => "Web",
        "staticUri" => "/",
        "url" => "http://127.0.0.1:8084/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 32678,
    ],
    'demoServerUrl' => [
        "http://127.0.0.1:8083/",
        "http://127.0.0.1:8083/",
    ],
    'debugRPC' => false,
    'uCenterServerUrl' => [
        "http://ucenter.phalconplus.com",
    ]
];