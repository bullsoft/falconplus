<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Phalcon+ 快速开始</h1>
    </div>

    <div class="row">
        <!-- Sidebar Column -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="#dependency" class="list-group-item active">依赖安装</a>
                <a href="#install" class="list-group-item">Phalcon+安装</a>
                <a href="#project" class="list-group-item">构建项目</a>
                <a href="#config" class="list-group-item">Nginx配置</a>
            </div>
        </div>
        <!-- Content Column -->
        <div class="col-md-9">
            <h2 id="dependency">依赖安装</h2>
            <p>
                <ul>
                    <li><a href="http://phalconphp.com/en/download" target="_blank">Phalcon - a php framework which made with c/zephir</a></li>
                    <li><a href="https://github.com/laruence/yar" target="_blank">Yar - Yet another rpc</a></li>
                    <li><a href="https://getcomposer.org/" target="_blank">Composer - Dependency Manager for PHP</a></li>
                </ul>
            </p>

            <hr />
            <p>别得意，安装完依赖之后咱们还得继续 ...</p>
            <h2 id="install">Phalcon+ 安装</h2>
            <p>
             <pre>
                <code>
➜ git clone https://github.com/bullsoft/phalconplus.git
➜ cd phalconplus/ext/
➜ /usr/bin/phpize
➜ ./configure --with-php-config=/usr/bin/php-configure
➜ make
➜ make install
                </code>
             </pre>

            然后check一下扩展是否已经安装好了?
            <pre>
                <code>
➜ php -m | grep phalconplus
phalconplus
                </code>
            </pre>

            ... 完美！
            </p>

            <h2 id="project">构建项目</h2>
            <p>我们使用PHP包依赖管理工具Composer来构建项目：</p>
            <p>
                <pre>
                  <code class="shell">
➜ composer create-project bullsoft/fp-project fp-app
                    </code>
                </pre>
            </p>

            <p>
                然后看一下我们可以做什么？
                <pre>
                    <code>
➜ cd fp-app
➜ ./common/bin/fp-devtool
------- 华丽丽分割 -------
<img src="http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/fp-devtool-help.png" width="100%" />
                    </code>
                </pre>
            </p>
            <p>
              现在我们来创建模块，输入以下命令后根据引导完成即可。
              <pre>
                <code>
 ➜ ./common/bin/fp-devtool module create
                </code>
              </pre>
            </p>

            <p>
            查看模块：
            <pre>
                <code>
➜ ./common/bin/fp-devtool module list
------- 华丽丽分割 -------
<img src="http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/fp-devtool-module_list.png" width="100%" />
                </code>
            </pre>
            </p>

            <p>
              运行该模块：
            <pre>
                <code>
➜ ./common/bin/fp-devtool server start api
                </code>
            </pre>
            浏览器查看效果：
            <img src="http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/localhost_8000.png" width="100%" style="border: 1px solid black" />
            </p>

            <hr />

<h2 id="config">Nginx配置</h2>

<p>
当然，PHP内置的http服务非常不完善，我们还是需要配置nginx，先看看咱们的项目在哪个目录下：
    <pre>
        <code>
➜ pwd
/Users/guweigang/github/bullsoft/fp-app/api
        </code>
    </pre>

然后在nginx.conf中加入这一段：
    <pre>
        <code>
server {

      listen 80;

      server_name demo.phalconplus.com;

      access_log  logs/demo.phalconplus.access.log  main;

      index index.php index.html index.htm;

      set $root_path '/Users/guweigang/github/bullsoft/fp-app/api/public';

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
        </code>
    </pre>

别忘了修改hosts文件
    <pre>
        <code>
➜ sudo vi /etc/hosts
        </code>
    </pre>

在文件末尾加入这一行
    <pre>
        <code>
127.0.0.1 demo.phalconplus.com
        </code>
    </pre>

现在你就可以在浏览器地址栏自信地敲下：<a href="http://demo.phalconplus.com" target="_blank">http://demo.phalconplus.com</a>，然后映入眼帘的绝对是：

            <center><h3>It works.</h3></center>
</p>

        </div>
    </div>
</div>
