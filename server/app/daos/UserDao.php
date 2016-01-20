<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/20
 * Time: 17:45
 */

namespace Demo\Server\Daos;
use Demo\Server\Models;

class UserDao
{
    public static function exists($column, $value)
    {
        $userInfo = Models\UserInfo::findFirst([
            "{$column}=:value:",
            "bind" => [
                "value" => $value
            ]
        ]);
        return $userInfo;
    }
}