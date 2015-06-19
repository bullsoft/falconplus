<?php
class TestTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params = []) {
        var_dump(json_decode($params[0], true));
        return 1;
    }
}