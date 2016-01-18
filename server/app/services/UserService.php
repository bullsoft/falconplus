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
use Demo\Server\Models;
use Common\Protos\Exception\SystemBusy;
use Common\Protos\Exception\UserNotExists;

/**
 * Class UserService
 * @package Demo\Server\Services
 */
class UserService extends \PhalconPlus\Base\Service
{
    const DEFAULT_INVITE_CODE = "A0000000";
    const DEFAULT_INVITE_UID = 0;

    public function passwdMatch(ProtoLoginInfo $loginInfo)
    {
        $mobile = $loginInfo->getMobile();
        $passwd = $loginInfo->getPasswd();

        $userInfo = Models\UserInfo::findFirst([
            "mobile = :mobile:",
            "bind" => [
                "mobile" => $mobile,
            ]
        ]);

        if(empty($userInfo)) {
            throw new UserNotExists(["login failed", $mobile]);
        }

        $hashPasswd = hash("sha256", $userInfo->salt . $passwd);
        if($hashPasswd != $userInfo->passwd) {
            // throw new PasswdNotMatchException();
        }

        // return xxx;

    }

    public function create(ProtoRegInfo $regInfo)
    {
        $userInfo = new Models\UserInfo();
        $userInfo->mobile = $regInfo->mobile;
        $salt = random_bytes(32);
        $userInfo->salt = $salt;
        $passwd = hash("sha256", $salt.$userInfo->getPasswd());
        $userInfo->passwd = $passwd;
        $userInfo->deviceId = 1;
        $userInfo->refer = "HOME";
        $userInfo->inviteUserId = self::DEFAULT_INVITE_UID;
        $userInfo->inviteCode = self::DEFAULT_INVITE_CODE;
        $userInfo->status = EnumUserStatus::NORMAL;
        if($userInfo->save() == false) {
            throw new SystemBusy(["failed to create user, userInfo: ", $userInfo->toArray()], $this->logger);
        }
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