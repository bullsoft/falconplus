<?php
namespace Demo\Web\Controllers;
use Demo\Web\Models\DealRecord;

class IndexController extends \Phalcon\Mvc\Controller
{
    /**
     * 模板使用示例
     */
    public function indexAction()
    {
        $this->view->setVar("hello", "hello, world! ");
        $this->view->setVar("world", array("foo" => "bar"));
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
            throw new \Common\Protos\Exception\UserNotExists("User 3 not exists in database", $this->logger);
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
        throw \Common\Protos\EnumExceptionCode::newException(10001, $this->di->getLogger());
        //var_dump(\Demo\Protos\EnumExceptionCode::getByCode(10001));
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
}