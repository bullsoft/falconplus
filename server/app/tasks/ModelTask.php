<?php
class ModelTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params = array()) {
        var_dump($params);
    }
}