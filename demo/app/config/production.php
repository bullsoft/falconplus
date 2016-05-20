<?php
$host = $_SERVER["HTTP_HOST"];
$schema = "http";
if(strpos($host, "bullsoft.org") !== false) {
    $schema = "https";
}
$url = $schema . "://" . $host . "/";

return [
    "view" => [
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ],
    'application' => [
        "name"  => "demo-web",
        "ns"    => "Demo\Web\\",
        "mode"  => "Web",
        "staticUrl" => "https://bullsoft-static.oss-cn-beijing.aliyuncs.com/",
        "url" => $url,
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ],
    'redis' => [
        'host' => "10.161.41.106",
        'port' => 3306,
        'auth' => getenv("PHP_REDIS_AUTH"),
    ],
    'redis_r' => [
        'host' => ["10.161.41.106", "10.144.14.81"],
        'port' => 3306,
        'auth' => getenv("PHP_REDIS_AUTH"),
    ],
    'demoServerUrl' => [
        "http://10.144.14.81:8003",
        "http://10.161.41.106:8003",
    ],
    'debugRPC' => false,
];