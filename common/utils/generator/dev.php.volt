return array(
    'application' => array(
        "name"  => "{{module}}",
        "ns"    => "{{rootNs}}\\{{mode}}\\",
        "mode"  => "{{mode}}",
        "staticUri" => "/",
        "url" => "http//server.localhost.com/",
        "logFilePath" => "/tmp/{{rootNs}}_{{module}}.log",
    ),
    "view" => array(
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
    'db' => array(
        "host" => "127.0.0.1",        
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "test",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
);