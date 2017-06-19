<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/19
 * Time: 15:26
 */

namespace Common\Protos;
use \PhalconPlus\Assert\Assertion as Assert;


class ProtoRegInfo extends ProtoBase
{
    private $mobile;
    private $email;
    private $passwd;
    private $inviteCode = self::NULL_VALUE;

    /**
     * @return mixed
     */
    public function getMobile()
    {
        Assert::notEmpty($this->mobile);
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        Assert::notEmpty($mobile);
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        Assert::notEmpty($this->email);
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        Assert::notEmpty($email);
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPasswd()
    {
        Assert::notEmpty($this->passwd);
        return $this->passwd;
    }

    /**
     * @param mixed $passwd
     */
    public function setPasswd($passwd)
    {
        Assert::notEmpty($passwd);
        $this->passwd = $passwd;
        return $this;
    }

    /**
     * @return string
     */
    public function getInviteCode()
    {
        return $this->inviteCode;
    }

    /**
     * @param string $inviteCode
     */
    public function setInviteCode($inviteCode)
    {
        Assert::notEmpty($inviteCode);
        $this->inviteCode = $inviteCode;
        return $this;
    }
}