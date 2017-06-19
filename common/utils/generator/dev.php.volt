return array(
    'application' => array(
        "name"  => "{{module}}",
        "ns"    => "{{rootNs}}\\{{mode}}\\",
        "mode"  => "{{mode}}",
        "staticUrl" => "/",
        "url" => "http//server.localhost.com/",
        "logFilePath" => "/tmp/{{rootNs}}_{{module}}.log",
    ),
{% if mode == "Web" %}
    "view" => array(
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
{% endif %}
    'db' => array(
        "host" => "127.0.0.1",        
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "test",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
        "retryInterval" => 200000, // 失败重试间隔200ms
        "retryTimes" => 5, //失败重试次数
    ),
{% if mode == "Web" %}
    'demoServerUrl' => array(
        "http://server.phalconplus.com",
    ),
    'debugRPC' => false,
{% endif %}
);