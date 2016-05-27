<?php
namespace Common\Protos;
use \PhalconPlus\Enum\AbstractEnum;

class EnumPaySP extends AbstractEnum
{
    const __default = self::ALIPAY;
    const ALIPAY = "alipay";
    const UNIONPAY = "unionpay";
    const WECHATPAY = "wechatpay";
}