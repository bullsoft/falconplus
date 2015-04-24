<!-- Marketing Icons Section -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Phalcon+ 欢迎您 !
        </h1>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-fighter-jet"></i> 基于Phalcon</h4>
            </div>
            <div class="panel-body">
                <p>Phalcon也作falcon，意为猎鹰，一种猛禽，飞得快，飞得高，飞得好，她是对PHP框架的新尝试。</p>
                <a href="http://phalconphp.com" class="btn btn-default" target="_blank">了解更多</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-gift"></i> 免费 &amp; 开源</h4>
            </div>
            <div class="panel-body">
                <p>PhalconPlus完全免费，并且开源，你可以轻松获取它的源代码，并且做任何更改无需合并到官方分支。</p>
                <a href="https://github.com/BullSoft/falconplus" target="_blank" class="btn btn-default">falconplus</a>
                <a href="https://github.com/BullSoft/phalconplus" target="_blank" class="btn btn-default">phalconplus</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><i class="fa fa-fw fa-compass"></i> 上手简单</h4>
            </div>
            <div class="panel-body">
                <p>上手简单，0门槛，所有准备工作基本都可以自动完成。极速提升开发效率，从此跟XX说拜拜。</p>
                <a href="http://phalconphp.org/topics/24" target="_blank" class="btn btn-default">了解更多</a>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<!-- Portfolio Section -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">代码片断</h2>
    </div>
    <div class="col-md-6 col-sm-6">
            <pre>
                <code class="php">// 入口文件, 仅两行就搞定, 还能再简单吗?

$bootstrap = new \PhalconPlus\Bootstrap(dirname(__DIR__));
$bootstrap->exec();

// end

                </code>
            </pre>
    </div>
    <div class="col-md-6 col-sm-6">
            <pre>
                <code class="php">// QueryBuilder
DealRecord::getInstance() // 非单例,每次创建实例
    ->createBuilder("dr") // dr为模型的别名
    ->columns("dr.dealId, dr.borrowerId")
    ->limit(1)
    ->getQuery()
    ->execute();
                </code>
            </pre>
    </div>
    <div class="col-md-8 col-sm-6">
        <pre>
            <code class="php">// register db service
$di->setShared('dbDemo', function() use ($di) {
    $mysql = new \PhalconPlus\Db\Mysql($di, "dbDemo");
    $connection = $mysql->getConnection();

    $eventsManager = new \Phalcon\Events\Manager();
    $profiler = $di->getProfiler();
    $eventsManager->attach('db', function($event, $connection) use ($profiler) {
        if ($event->getType() == 'beforeQuery') {
            $profiler->startProfile($connection->getSQLStatement());
        }
        if ($event->getType() == 'afterQuery') {
            $profiler->stopProfile();
        }
    });
    $connection->setEventsManager($eventsManager);
    return $connection;
});

            </code>
        </pre>
    </div>

    <div class="col-md-4 col-sm-6">
        <pre>
            <code class="php">// db 配置
// 支持连接超时,失败重试
return array(
    'dbDemo' => array(
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "p2p",
        "charset" => "utf8",
        // 连接超时 1 秒
        "timeout" => 1,
        // 失败重试间隔200ms
        "retryInterval" => 200000,
        // 失败重试次数
        "retryTimes" => 5,
    ),
);

            </code>
        </pre>
    </div>


    <div class="col-md-6 col-sm-6">
        <pre>
            <code class="php">// 基于Yar的RPC服务
// Yar是鸟哥(http://www.laruence.com/)为PHP量身定制的RPC
$di->set("rpc", function() use ($di, $config, $bootstrap) {
    $client = null;
    if($config->debugRPC == true) {
        // 如果debugRPC==true, 则加载server模块的配置, 直接本地调用
        $bootstrap->dependModule("server"); // 你很可能需要修改模块名
        $client = new \PhalconPlus\RPC\Client\Adapter\Local($di);
    } else {
        // 获取服务地址列表
        $remoteUrls = $config->demoServerUrl;
        $client = new \PhalconPlus\RPC\Client\Adapter\Remote($remoteUrls->toArray());
        $client->SetOpt(\YAR_OPT_CONNECT_TIMEOUT, 5);
    }
    return $client;
});

            </code>
        </pre>
    </div>

    <div class="col-md-6 col-sm-6">
        <pre>
            <code class="php"> // 基于Yar的RPC服务
$request = new \Demo\Protos\RequestDemo();
$request->setFoo("hello")
        ->setBar("world");

$protoUser = new \Demo\Protos\ProtoUser();
$protoUser->setUsername("guweigang")
          ->setPassword("123456")
          ->setStatus(new \Demo\Protos\EnumUserStatus(3));

$request->setUser($protoUser);

$response = $this->rpc->callByObject(array(
    "service" => "\\Demo\\Server\\Services\\Demo",
    "method" => "demo",
    "args"   => $request,
));
echo json_encode($response);
            </code>
        </pre>
    </div>

    <div class="col-md-8 col-sm-6">
        <pre>
            <code class="php">//自定义logger格式和处理
$di->setShared("logger", function() use ($di, $config){
    $logger = new \PhalconPlus\Logger\Adapter\FilePlus($config->application->logFilePath);
    $logger->registerExtension(".de", [\Phalcon\Logger::DEBUG]);
    // 添加formatter
    $formatter = new \PhalconPlus\Logger\Formatter\LinePlus("[%date%][%trace%][%uid%][%type%] %message%");
    $formatter->addProcessor("uid", new UidProcessor(18));
    $formatter->addProcessor("trace", new TraceProcessor(TraceProcessor::T_CLASS));

    $logger->setFormatter($formatter);
    return $logger;
});
            </code>
        </pre>
    </div>
    <div class="col-md-4 col-sm-6">
        <pre>
            <code>
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:192][2dc6b1bcf7c49330e9][DEBUG] 我是日志1
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:193][2dc6b1bcf7c49330e9][DEBUG] 我是日志2
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:194][2dc6b1bcf7c49330e9][DEBUG] 但是我们是同一个请求产生的日志
            </code>
        </pre>
    </div>
    <div class="col-md-7 col-sm-6">
        <pre>
            <code class="php">// set view with volt
$di->set('view', function() use ($di) {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir(__DIR__.'/views/');
    $view->registerEngines(array(
        ".volt" => function($view, $di) {
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
            $volt->setOptions(array(
                "compiledPath"      => $di->get('config')->view->compiledPath,
                "compiledExtension" => $di->get('config')->view->compiledExtension,
        ));
    // 如果模板缓存目录不存在，则创建它
    if(!file_exists($di->get('config')->view->compiledPath)) {
        mkdir($di->get('config')->view->compiledPath, 0777, true);
    }
    $compiler = $volt->getCompiler();
    // 注册PHP函数,在volt模板中可以使用php built-in函数
    $compiler->addExtension(new \PhalconPlus\Volt\Extension\PhpFunction());
        return $volt;
    }
    ));
    return $view;
});
            </code>
        </pre>
    </div>
    <div class="col-md-5 col-sm-6">
        <pre>
            <code>
{ { substr(hello, 0, -1) } }
{ { json_encode(world, constant("JSON_PRETTY_PRINT")) } }
            </code>
        </pre>
    </div>

</div>
<!-- /.row -->