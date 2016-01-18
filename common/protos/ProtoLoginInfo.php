<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/14
 * Time: 18:32
 */

namespace Common\Protos;
use \PhalconPlus\Assert\Assertion as Assert;

class ProtoLoginInfo extends ProtoBase
{
    private $mobile;
    private $passwd;

    /**
     * @optional
     */
    private $captcha = self::NULL_VALUE;

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
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPasswd()
    {
        Assert::notEmpty($this->mobile);
        return $this->passwd;
    }

    /**
     * @param mixed $passwd
     */
    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
        return $this;
    }

    /**
     * @return null
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @param null $captcha
     */
    public function setCaptcha($captcha)
    {
        Assert::notEmpty($captcha);
        $this->captcha = $captcha;
    }
}