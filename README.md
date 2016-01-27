# falconplus - 一个构建在phalconphp之上PHP扩展

1. 先安装 phalcon, phalconplus, yar, msgpack

2. mkdir /tmp/compiled/

3. git clone https://github.com/bullsoft/falconplus.git

git submodule update --init --recursive

4. Nginx配置

```nginx
    server {
      listen 80;
      server_name demo.phalconplus.com;
      access_log  logs/demo.phalconplus.access.log  main;
      index index.php index.html index.htm;
      set $root_path '/Users/guweigang/github/bullsoft/falcon/demo/public';
      root $root_path;
      try_files $uri $uri/ @rewrite;
      location @rewrite {
          rewrite ^/(.*)$ /index.php?_url=/$1 last;
      }
      location ~ \.php {
          fastcgi_pass 127.0.0.1:9000;
          include fastcgi_params;
          fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
      }
      location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
          root $root_path;
      }
      location ~ /\.ht {
          deny all;
      }
   }
```

## 演示
 - Frontend: http://demo.phalconphp.org
 - Backend: http://server.phalconphp.org

如果你想调用PhalconPlus的服务，你也可以这样开始：

```php
<?php
$client = new \Yar_Client("http://server.phalconphp.org");
$client->SetOpt(YAR_OPT_CONNECT_TIMEOUT, 3);

$result = $client->callByObject(array(
    "service" => "\\Demo\Server\Services\\Demo",
    "method" => "demo",
    "args" => array(
        "foo" => "hello",
        "bar" => "world",
        "user" => array(
            "username" => "guweigang",
            "password" => "123456",
        ),
    ),
));
echo json_encode($result);
```
