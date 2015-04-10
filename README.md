# falconplus

1. 先安装 phalconplus，一个构建在phalconphp之上PHP扩展

2. mkdir /tmp/compiled/

3. Nginx配置

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
