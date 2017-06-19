<?php
namespace Demo\Web\Controllers;
use Demo\Web\Models\DealRecord;
use Gregwar\Captcha\CaptchaBuilder;

class IndexController extends BaseController
{
    /**
     * 模板使用示例
     */
    public function indexAction()
    {
        $this->view->setVar("hello", "hello, world! ");
        $this->view->setVar("world", array("foo" => "bar"));
    }

    public function batchAction()
    {
    }

    /**
     * Query Builder查询示例
     */
    public function dbAction()
    {
        $a = DealRecord::find()->toArray();
        // var_dump($a);
        $b = DealRecord::getInstance()
           ->createBuilder("dr")
           ->columns("dr.dealId, dr.borrowerId")
           ->limit(1)
           ->getQuery()
           ->execute();

        $profiles = $this->profiler->getProfiles();

        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "<br />";
            echo "Start Time: ", $profile->getInitialTime(), "<br />";
            echo "Final Time: ", $profile->getFinalTime(), "<br />";
            echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "<br />";
        }

        var_dump($b->toArray());
    }

    /**
     * 复杂RPC调用示例
     */
    public function rpcAction()
    {
        $request = new \Common\Protos\RequestDemo();
        $request->setFoo("hello")
            ->setBar("world");

        $protoUser = new \Common\Protos\ProtoUser();
        $protoUser->setUsername("guweigang")
            ->setPassword("123456")
            ->setStatus(new \Common\Protos\EnumUserStatus(3));

        $request->setUser($protoUser);

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Demo",
            "method" => "demo",
            "args"   => $request,
        ));

        echo json_encode($response);
    }

    /**
     * 简单RPC调用示例
     */
    public function simplerpcAction()
    {
        $request = new \PhalconPlus\Base\SimpleRequest();
        $request->setParam("foo");
        $request->setParam("bar");
        $request->setParam(array("hello", "world"));

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Demo",
            "method" => "simple",
            "args" => $request,
            "logId" => $this->logger->getFormatter()->uid,
        ));
        var_dump($response);
    }

    /**
     * 分页类使用示例
     */
    public function pagableAction()
    {
        $pagable = new \PhalconPlus\Base\Pagable();
        $pagable->setPageSize(10);
        $pagable->setPageNo(2);

        $orderBy1 = new \PhalconPlus\Base\ProtoOrderBy();
        $orderBy1->setProperty("foo");
        $orderBy1->setDirection(new \PhalconPlus\Enum\OrderByDirection("ASC"));

        $orderBy2 = new \PhalconPlus\Base\ProtoOrderBy();
        $orderBy2->setProperty("bar");
        $orderBy2->setDirection(new \PhalconPlus\Enum\OrderByDirection("ASC"));

        $pagable->setOrderBy($orderBy1)
            ->setOrderBy($orderBy2);

        var_dump($pagable->toArray());
    }

    /**
     * 分页查询示例
     */
    public function pageAction()
    {
        $pagable = new \PhalconPlus\Base\Pagable();
        $pagable->setPageSize(10);
        $pagable->setPageNo(1);

        $orderBy1 = new \PhalconPlus\Base\ProtoOrderBy();
        $orderBy1->setProperty("investorId");
        $orderBy1->setDirection(new \PhalconPlus\Enum\OrderByDirection("DESC"));
        $pagable->setOrderBy($orderBy1);

        $orderBy2 = new \PhalconPlus\Base\ProtoOrderBy();
        $orderBy2->setProperty("id");
        $orderBy2->setDirection(new \PhalconPlus\Enum\OrderByDirection("ASC"));
        $pagable->setOrderBy($orderBy2);

        $page = DealRecord::getInstance()->findByPagable($pagable, [
            "conditions" => "id > :id:",
            "bind" => ["id" => 1],
            "columns" => "id, dealId, investorId"
        ]);

        $profiles = $this->profiler->getProfiles();
        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "<br />";
            echo "Start Time: ", $profile->getInitialTime(), "<br />";
            echo "Final Time: ", $profile->getFinalTime(), "<br />";
            echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "<br />";
        }
        var_dump($page->toArray());
    }

    /**
     * 枚举示例，当传入的值不在枚举范围内时，会抛异常
     *
     */
    public function enumAction($userStatus = 0)
    {
        try {
            \PhalconPlus\Assert\Assertion::numeric($userStatus);
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo "<br />";
        }

        // 0, 1, 2, 3, 4 才是合法的枚举值
        try {
            $a = new \Common\Protos\EnumUserStatus($userStatus);
            echo "Valid user Status is: " . $a;
        } catch (\Exception $e) {
            echo "Exception: " . $e->getMessage();
        }
    }

    /**
     * 抛异常示例，如果传入日志类对象，则会打印日志
     */
    public function eAction()
    {
        try {
            // throw new \PhalconPlus\Base\Exception("Test Exception");
            // throw new \Demo\Protos\ExceptionUserNotExists("User 3 not exists in database");
            throw new \Common\Protos\Exception\UserNotExists(["User 3 not exists in database", 7], $this->logger);
        } catch (\Exception $e) {
            echo $e->getMessage() . "<br />";
            echo $e->getCode() . "<br />";
            echo $e->getLevel() . "<br />";
        }
    }

    /**
     * 通过Code唤醒异常
     */
    public function wakeExceptionAction()
    {
        try {
            throw new \Exception("用户不存在哈", 10001);
        } catch(\Exception $e) {
            throw \Common\Protos\EnumExceptionCode::newException($e, $this->di->getLogger());
        }
    }

    public function loggerAction()
    {
        $this->logger->log("我是日志1");
        $this->logger->log("我是日志2");
        $this->logger->log("但是我们是同一个请求产生的日志");
        // throw new \Common\Protos\Exception\UserNotExists("User 3 not exists in database", $this->di->getLogger());
    }

    public function testDIAction()
    {
        $this->di->get("requestCheck", ["hello", "world"]);
    }

    public function testCaptchaAction()
    {
        $builder = new CaptchaBuilder;
        $builder->build();

        header('Content-type: image/jpeg');
        $builder->output();
    }

    public function yarAction()
    {
        /**
         * Use CURL For PHP implement  yar client.
         */
        // Create request body
        $body = '{"i":123123,"m":"test","p":[]}';
        // Create Yar Header protocol,about pack rule,more see:http://php.net/manual/zh/function.pack.php
        $format = "I1S1I1I1C32C32I1";   // 82bit
        $pack = pack($format,123123,0,1626136448,0,
                     '','','','','','','','','','',
                     '','','','','','','','','','',
                     '','','','','','','','','','',
                     '','',
                     '','','','','','','','','','',
                     '','','','','','','','','','',
                     '','','','','','','','','','',
                     '','', strlen($body)
        );
        // Create Package Protocol
        $format = "a8";     //8 bit
        $packager_pack = pack($format, 'JSON');

        $protocol_data = $pack.$packager_pack.$body;

        $uri = "http://127.0.0.1:8083";
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $protocol_data );
        $return = curl_exec ( $ch );
        $content = substr($return,82 + 8,strlen($return));
        $content = json_decode($content,true);
        if($content['e']){      //Exception
            throw new \Exception($content['e']);
        }
        if($content['o']){      //Output
            echo $content['o'];
        }
        $data = $content['r'];          //Return
        var_dump($content);
        exit;
    }

    public function abAction()
    {
        var_dump(new \Phalcon\Acl\Adapter\Database([]));
        exit;
    }
}