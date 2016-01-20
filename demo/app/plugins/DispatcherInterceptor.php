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
        if ($anno->has('disableView')) {
            $this->view->disable();
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
            $response->setJsonContent($returnValue, \JSON_UNESCAPED_UNICODE);
            $dispatcher->setReturnedValue($response);
        }
        return true;
    }
}