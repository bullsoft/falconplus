<?php
class ModelTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params = array()) {
        var_dump($params);
        return [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
        ];
    }
}