# Phalcon+开发手册

标签（空格分隔）： PHP Phalcon Zephir Framework

---

在阅读此文档前，请确保你已经看过[快速开始][1]。如果顺利的话，恭喜你，你已经成功把框架运行起来了，已经成功了一半哦。

## 1. 什么是Phalcon+？ ##

先回答大家几个问题
> Q: 为什么又搞一个框架呀？

NO, NO, NO... 我并没有重新开发一个新框架，`Phalcon+`是一个基于Phalcon的工具集，正是因为Phalcon的灵活性和模块间的低耦合性才让我有这个机会去包装她、修饰她、甚至改变她。

> Q: 为什么不用原生的Phalcon？

正是因为Phalcon极高的灵活性，赋予了开发者过多的选择权。有时候路口太多容易迷失，所以当我做完这一系列选择后，我把这个过程记录了下来，并逐渐演化成了现在的`Phalcon+`。为了让每个开发者不重复去做这些选择，我毅然将`Phalcon+`开源，供大家交流和学习。

So, 总结来说，`Phalcon+`并不是一个全新的框架，而是对Phalcon框架的一次优秀实践，是对Phalcon框架的再次加工和补充，能让Phalcon开发者更简单地入门和精通，最后达到天人合一的最高境界。

## 2. 约束 ##

 - 不支持Phalcon的多模块结构
 - 所有模块目录结构都是同构的
 - 模块是有工作模式的，如：Web, Server, Task等...，不同模式的模块角色不一样
 - 无论哪种模式，入口文件都完全一样
 - Buit-in RPC，使用中国PHP第一人鸟哥的Yar组件
 - 所有模块都依赖全局的common目录

## 3. 目录介绍 ##

### 3.1 Common模块介绍 ###
common模块能帮你省去很多重复的工作量，且看下面：

```
➜  common git:(master) ✗ tree -L 2
.
├── README.md
├── app                              应用目录
│   ├── Task.php                     模块引导文件
│   ├── config                       配置文件目录
│   ├── tasks                        任务控制器目录
│   └── templates                    代码模块目录
├── bin
│   └── fp-devtool                   开发工具-可执行文件
├── composer.json
├── config                           全局配置文件目录
│   └── config.php
├── load                             全局加载目录
│   ├── default-cli.php                - for task
│   ├── default-micro.php              - for micro
│   ├── default-web.php                - for web
│   └── default.php                    - for all
└── vendor                           第三方库
    └── BullSoft
```

`common`其实是一个标准的`Phalcon+ CLI 模块`，承担了整个项目的构建工作。

`Phalcon+`鼓励大家使用`common`中的工具，如：生成一个模块，已知模块的三要素为：

 - 模块名(即模块目录名)：test
 - 模块根命名空间：Test
 - 模块的工作模式: Web

使用的工具如下：
```shell
➜ $ ./common/bin/fp-devtool module create
```
按照引导完成即可。

### 3.2 模块目录介绍 ###

```
➜ tree
.
├── app                              应用目录
│   ├── Module.php                   模块引导文件
│   ├── config                       模块配置文件夹
│   │   └── dev.php                  开发环境配置文件，由phalconplus.env决定
│   ├── controllers                  控制器文件夹
│   │   ├── ErrorController.php      Error控制器
│   │   └── IndexController.php      Index控制器    
│   └── views                        视图文件夹
│       └── index                    IndexController对应的视图文件夹
└── public                           入口及静态资源文件夹
    └── index.php                    入口文件
```
#### 3.2.1 统一的入口文件 ####

```php
<?php
$bootstrap = new \PhalconPlus\Bootstrap(dirname(__DIR__));
$bootstrap->exec();
```

#### 3.2.2 解读配置文件 ####

配置对于`Phalcon+`来说是不可省略的，它就在那儿
```php
<?php
return [
    'application' => [
        "name"  => "demo-web",
        "ns"    => "Demo\\Web\\",
        "mode"  => "Web",
        "staticUri" => "/",
        "url" => "http://127.0.0.1:8084/",
        "logFilePath" => "/tmp/demo_phalconplus.log",
    ],
];
```

 
  [1]: http://phalconphp.org/quick_start.html "快速开始"
