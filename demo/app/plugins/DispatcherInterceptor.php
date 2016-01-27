<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/18
 * Time: 15:38
 */

namespace Demo\Web\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use PhalconPlus\Base\SimpleRequest;
use Common\Protos\Exception\NeedLogin;

class DispatcherInterceptor extends Plugin
{
    protected $di;
    protected $eventManager;

    public function __construct($di, $evtManager)
    {
        $this->di = $di;
        $this->eventManager = $evtManager;
    }

    public function beforeDispatch(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        return true;
    }

    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $annotations = new \Phalcon\Annotations\Adapter\Memory();
        $method = $dispatcher->getActiveMethod();
        $anno = $annotations->getMethod(get_class($dispatcher->getActiveController()), $method);

        // 禁止模板
        if($anno->has('disableView') || $anno->has('api')) {
            $this->view->disable();
        }

        // 不允许匿名
        if($anno->has('disableGuest')) {
            if(!$this->session->has('identity')) {
                if(!$anno->has('api')) {
                    $response = new \Phalcon\Http\Response();
                    $response->redirect("user/web-login");
                    $dispatcher->setReturnedValue($response);
                    return false;
                } else {
                    throw new NeedLogin(["user need login to access this resource"]);
                }
            } else {
                $request = new SimpleRequest();
                $request->setParam($this->session->get('identity'));
                $response = $this->rpc->callByObject(array(
                    "service" => "\\Demo\\Server\\Services\\User",
                    "method" => "getUserById",
                    "args" => $request,
                    "logId" => $this->logger->getFormatter()->uid,
                ));
                $this->di->setShared("user", function() use ($response) {
                    return $response;
                });
            }
        }

        return true;
    }

    public function afterExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $returnValue = $dispatcher->getReturnedValue();
        if(is_array($returnValue) || is_object($returnValue)) {
            $return = array(
                'status' => 200,
                'data' => (array) $returnValue,
                'msg' => '',
            );
            $response = new \Phalcon\Http\Response();
            $response->setHeader('Content-Type', 'application/json');
            $response->setJsonContent($return, \JSON_UNESCAPED_UNICODE);
            $dispatcher->setReturnedValue($response);
        }
        return true;
    }
}