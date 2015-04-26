<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Phalcon+ 快速开始
        </h1>
    </div>

    <div class="row">
        <!-- Sidebar Column -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="#dependency" class="list-group-item active">依赖安装</a>
                <a href="#install" class="list-group-item">Phalcon+安装</a>
                <a href="#project" class="list-group-item">构建项目</a>
                <a href="#config" class="list-group-item">配置</a>
                <a href="#model" class="list-group-item">生成模型</a>
            </div>
        </div>
        <!-- Content Column -->
        <div class="col-md-9">
            <h2 id="dependency">依赖安装</h2>
            <p>
                <ul>
                    <li><a href="http://zephir-lang.com/install.html" target="_blank">Zephir - lang for php extension</a></li>
                    <li><a href="http://phalconphp.com/en/download" target="_blank">Phalcon - a php framework which made with c/zephir</a></li>
                    <li><a href="https://github.com/laruence/yar" target="_blank">Yar - yet another rpc</a></li>
                </ul>
            </p>

            <hr />

            <h2 id="install">Phalcon+ 安装</h2>
            <p>
                <pre>
                <code>
git clone https://github.com/BullSoft/phalconplus.git
cd phalconplus
zephir clean
zephir build
                </code>
                </pre>

            然后check一下是否已经安装好了?
            <pre>
                <code>
➜ git:(master) php -m | grep phalconplus
phalconplus
                </code>
            </pre>
            </p>

            <h2 id="project">构建项目</h2>

            <p>首先为你的项目新建一个干净的目录，这里假设目录名是demo
                <pre>
                  <code class="shell">
mkdir demo
cd demo
git clone https://github.com/BullSoft/falconplus-common.git common
                    </code>
                </pre>
            </p>

            <p>
                然后生成项目结构
                <pre>
                    <code>
cd common/utils/

➜ git:(master) php generator.php
用法：php generator.php namespace(根命名空间) module(模块名称) mode(运行模式)

运行模式可选值为:
 - Web: 常用于API和Frontend
 - Cli: 常用于任务
 - Srv: 常用于服务


➜ git:(master) php generator.php Test test Web
正在为你生成 Phalcon+ 模块, 根命名空间: Test, 模块名: test, 运行模式：Web ...
Finish.⏎                
                    </code>
                </pre>
            </p>

            <p>

            这时候你应该能看到test目录的结构了
            <pre>
                <code>
➜ git:(master) cd ../../test

➜ tree
.
├── app
│   ├── Module.php
│   ├── config
│   │   └── dev.php
│   ├── controllers
│   │   ├── ErrorController.php
│   │   └── IndexController.php
│   └── views
│       └── index
└── public
    └── index.php
                </code>
            </pre>
            </p>

            <hr />

<h2 id="config">配置</h2>

<p>
这个时候你应当开始配置nginx了，先看看咱们的项目在哪个目录下：
    <pre>
        <code>
➜ pwd
/Users/guweigang/github/bullsoft/demo/test
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

      set $root_path '/Users/guweigang/github/bullsoft/demo/test/public';

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

            <h3>It works.</h3>
</p>

        </div>
    </div>
</div>