<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/12
 * Time: 18:39
 */

namespace Demo\Server\Services;
use Common\Protos\EnumUserStatus;
use PhalconPlus\Assert\Assertion as Assert;
use Common\Protos\ProtoLoginInfo;
use Common\Protos\ProtoRegInfo;

use Demo\Server\Models;
use Demo\Server\Daos;

use Common\Protos\Exception\SystemBusy;
use Common\Protos\Exception\UserNotExists;

/**
 * Class UserService
 * @package Demo\Server\Services
 */
class UserService extends \PhalconPlus\Base\Service
{
    const DEFAULT_INVITE_UID = 0;

    public function passwdMatch(ProtoLoginInfo $loginInfo)
    {
        $mobile = $loginInfo->getMobile();
        $passwd = $loginInfo->getPasswd();

        $userInfo = Daos\UserDao::exists("mobile", $mobile);

        if(empty($userInfo)) {
            throw new UserNotExists(["login failed", $mobile]);
        }

        $hashPasswd = hash("sha256", hex2bin($userInfo->salt) . $passwd);
        if($hashPasswd != $userInfo->passwd) {
            throw new \Exception("密码不匹配");
        }
        $response = new \PhalconPlus\Base\SimpleResponse;
        $response->setResult($userInfo->toArray());
        return $response;
    }

    public function create(ProtoRegInfo $regInfo)
    {
        // UserInfoModel
        $userInfo = new Models\UserInfo();
        $userInfo->mobile = $regInfo->getMobile();

        // 生成安全密码
        $salt = random_bytes(32);
        $userInfo->salt = bin2hex($salt);
        $passwd = hash("sha256", $salt.$regInfo->getPasswd());
        $userInfo->passwd = $passwd;

        // 注册设备及来源
        $userInfo->deviceId = 1;
        $userInfo->refer = "HOME";

        // 生成用户邀请码, 把手机号转成36进制([0-9][A-Z])
        $userInfo->inviteCode = strtoupper(base_convert($regInfo->getMobile(), 10, 36));

        // 通过手机验证码,合法用户
        $userInfo->status = EnumUserStatus::NORMAL;
        $userInfo->email = $regInfo->getEmail();

        // 处理邀请人信息
        $userInfo->inviteUserId = self::DEFAULT_INVITE_UID;
        if(!$regInfo->isNull("inviteCode")) {
            $inviteUser = Daos\UserDao::exists("inviteCode", $regInfo->getInviteCode());
            if($inviteUser != false) {
                $userInfo->inviteUserId = $inviteUser->id;
            }
        }

        if($userInfo->save() == false) {
            throw new SystemBusy(["failed to create user, userInfo: ", $userInfo->toArray()], $this->logger);
        }

        return [];
        // return response
    }

    public function changeStatus()
    {

    }

    public function addNickname()
    {

    }

    public function resetPasswd()
    {

    }

    public function verify()
    {

    }

    public function addEmail()
    {

    }

    public function sendMsg()
    {

    }

    public function verifyInviteCode()
    {

    }
}