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
                <a href="https://github.com/bullsoft/falconplus" target="_blank" class="btn btn-default">falconplus</a>
                <a href="https://github.com/bullsoft/phalconplus" target="_blank" class="btn btn-default">phalconplus</a>
                <a href="http://pan.baidu.com/s/1jGSfF1s" target="_blank" class="btn btn-default">dll下载</a>
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

            <pre><strong>入口文件</strong>
                <code class="php">// 入口文件, 仅两行就搞定, 还能再简单吗?

$bootstrap = new \PhalconPlus\Bootstrap(dirname(__DIR__));
$bootstrap->exec();

// end

                </code>
            </pre>
    </div>
    <div class="col-md-6 col-sm-6">
            <pre><strong>快速使用QueryBuilder</strong>
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
        <pre><strong>注册DB服务,添加profiler</strong>
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
        <pre><strong>db配置,支持连接超时/失败重试</strong>
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
        <pre><strong>注册RPC服务</strong>
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
        <pre><strong>RPC调用方式</strong>
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
        <pre><strong>注册logger, 自定义是亮点</strong>
            <code class="php">//自定义log格式和处理
$di->setShared("logger", function() use ($di, $config){
    $logger = new \PhalconPlus\Logger\Adapter\FilePlus($config->application->logFilePath);
    // debug类别的日志单独打印在以.de结尾的文件中
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
        <pre><strong>日志格式</strong>
            <code>
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:192][2dc6b1bcf7c49330e9][DEBUG] 我是日志1
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:193][2dc6b1bcf7c49330e9][DEBUG] 我是日志2
[2015-04-20 23:28:09][/Users/guweigang/github/bullsoft/falcon/demo/app/controllers/IndexController.php:194][2dc6b1bcf7c49330e9][DEBUG] 但是我们是同一个请求产生的日志
            </code>
        </pre>
    </div>
    <div class="col-md-7 col-sm-6">
        <pre><strong>模板设置,在模板中使用PHP函数</strong>
            <code class="php">// set view with volt
$di->set('view', function() use ($di) {
    // 此处省略很多代码 ...
    $compiler = $volt->getCompiler();
    // 注册PHP函数,在volt模板中可以使用php built-in函数
    $compiler->addExtension(new \PhalconPlus\Volt\Extension\PhpFunction());
        return $volt;
    }
    return $view;
});
            </code>
        </pre>
    </div>
    <div class="col-md-5 col-sm-6">
        <pre><strong>volt模板代码</strong>
            <code>
{ { substr(hello, 0, -1) } }
{ { json_encode(world, constant("JSON_PRETTY_PRINT")) } }
            </code>
        </pre>
    </div>

    <div class="col-md-6 col-sm-6">
        <pre><strong>枚举类</strong>
            <code>
namespace Demo\Protos;
use \PhalconPlus\Enum\AbstractEnum;
class EnumUserStatus extends AbstractEnum
{
    const __default = self::NORMAL;

    const NORMAL = 0;
    const INIT = 1;
    const NEED_VALID = 2;
    const BLOCK = 3;
    const DELETED = 4;
}

            </code>
        </pre>
    </div>


    <div class="col-md-6 col-sm-6">
        <pre><strong>枚举类使用</strong>
            <code>
try {
    \PhalconPlus\Assert\Assertion::numeric($userStatus);
} catch (\Exception $e) {
    echo $e->getMessage();
}
// 0, 1, 2, 3, 4 才是合法的枚举值
try {
    $userStatus = $this->request->getQuery("status");
    $a = new \Demo\Protos\EnumUserStatus($userStatus);
    echo "Valid user Status is: " . $a;
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
}
            </code>
        </pre>
    </div>

    <div class="col-md-6 col-sm-6">
        <pre><strong>异常枚举</strong>
            <code class="php">
namespace Demo\Protos;
use \PhalconPlus\Enum\Exception as EnumException;


class EnumExceptionCode extends EnumException
{
    const __default = self::UNKNOWN;

    /**
     * 请不要使用重复异常码
     */
    const UNKNOWN = 10000;
    const USER_NOT_EXISTS = 10001;
    const AUTH_FAILED = 10002;
    const NEED_LOGIN = 10003;

    protected static $details = [

        self::UNKNOWN => [
            "message" => "未知错误",
            "level" => EnumLoggerLevel::ERROR,
        ],

        self::USER_NOT_EXISTS => [
            "message" => "用户不存在，请核实后再试",
            "level" =>  EnumLoggerLevel::INFO,
        ],

    ];

    public static function exceptionClassPrefix()
    {
        return __NAMESPACE__ . "\\Exception\\";
    }
}

            </code>
        </pre>
    </div>
    <div class="col-md-6 col-sm-6">
        <pre><strong>异常枚举使用</strong>
            <code>
// 通过异常码唤醒异常
throw \Demo\Protos\EnumExceptionCode::newException(10001, $this->di->getLogger());
            </code>
        </pre>
        <pre><strong>此异常类根据异常枚举类自动生成</strong>
            <code>
namespace Demo\Protos\Exception;
/**
 * 此类由代码自动生成，请不要修改
 */
class UserNotExists extends \PhalconPlus\Base\Exception
{
    protected $code = 10001;
    protected $message = '用户不存在，请核实后再试';
    protected $level = 6;
}
            </code>
        </pre>
    </div>

</div>
<!-- /.row -->