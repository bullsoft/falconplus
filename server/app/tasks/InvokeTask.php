<?php

/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/26
 * Time: 17:59
 */

class InvokeTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params)
    {
        $config = $this->di->getConfig();
        $ns = $config->application->ns;
        $class = $ns . array_shift($params);
        $method = array_shift($params);
        $instance = new $class();
        $ret = call_user_func_array(array($instance, $method), $params);
        var_dump($ret);
    }
}