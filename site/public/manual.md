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
 - RPC使用鸟哥的Yar组件
 - 所有模块都依赖全局的common目录

## 3. 目录介绍 ##

### 3.1 Common目录介绍 ###
common目录的存在，能帮你省去很多的重复工作量，且看下面：

```
$ tree -L 2
.
├── config                      全局配置
│   └── config.php              全局配置文件
├── load
│   ├── default-cli.php         TASK模式下需要默认加载的服务
│   ├── default-micro.php       MICRO模式下需要默认加载的服务
│   ├── default.php             所有模式都需要加载的服务
│   └── default-web.php         WEB模式下需要加载的服务
├── protos                      跨模块的接口参数定义 以及 跨模块的异常定义
│   ├── EnumExceptionCode.php   异常码定义  
│   ├── EnumLoggerLevel.php     异常日志级别定义
│   ├── Exception               
│   ├── ProtoBase.php
│   ├── ProtoLoginInfo.php
├── utils                       工具文件夹
│   ├── exception.php           生成异常类的文件夹
│   ├── generator               生成模块的文件模板
│   ├── generator.php           生成模块的脚本
│   ├── init.php                tasks目录下的任务引导文件
│   ├── README.md               --
│   └── tasks                   与模块相关的全局TASK
└── vendor                      第三方库
    ├── BullSoft                布尔软件经年累月积累的PHP库
    ├── composer.json           Composer依赖描述文件
    ├── vendor                  Composer库安装路径
    └── Zend                    著名的Zend公司开发的PHP库
```

`common`目录如此重要，以至于在`快速开始`中，第一件做的跟代码相关的事情就是把`falcon-common`克隆到本地。

`Phalcon+`鼓励大家使用`common/utils`中的工具，如：生成一个模块，已知模块的三要素为：

 - 模块名(即模块目录名)：test
 - 模块根命名空间：Test
 - 模块的工作模式: Web

使用的工具如下：
```shell
➜ common/utils$ php generator.php Test test Web
正在为你生成 Phalcon+ 模块, 根命名空间: Test, 模块名: test, 运行模式：Web ...
Finish.⏎      
```

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
