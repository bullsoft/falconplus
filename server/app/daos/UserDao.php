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

    /**
     * @param $passwd string
     * @return array
     */
    public static function getPasswdAndSalt($passwd)
    {
        $salt = random_bytes(32);
        $passwd = hash("sha256", $salt.$passwd);
        return [
            'salt' => bin2hex($salt),
            'passwd' => $passwd,
        ];
    }

    /**
     * @param $iptPasswd string
     * @param $encPasswd string
     * @param $salt string
     * @return bool
     */
    public static function passwdMatch($iptPasswd, $encPasswd, $salt)
    {
        $hashPasswd = hash("sha256", hex2bin($salt).$inputPasswd);
        return $hashPasswd === $encPasswd;
    }
}