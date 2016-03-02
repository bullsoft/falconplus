<?php
namespace Common\Protos;
use \PhalconPlus\Enum\Exception as EnumException;
use \PhalconPlus\Assert\Assertion as Assert;

/** 
 * 建议从一个比较大的数字起，框架占用了 [0, 10000) 以内的异常码
 * 可根据此类自动生成异常类，类实现如下:
 * <code>
 * namespace Demo\Protos;
 * class ExceptionUserNotExists extends \PhalconPlus\Base\Exception
 * {
 *     protected $code = 10000;
 *     protected $message = "未知错误";
 *     protected $level = 3;
 * }
 * </code>
 *
 */
class EnumExceptionCode extends EnumException
{
    const __default = self::UNKNOWN;

    /**
     * 请不要使用重复异常码
     */
    const UNKNOWN = 10000;
    const USER_NOT_EXISTS = 10001;
    const AUTH_FAILED = 10002;
    const NEED_LOGIN = 10003;
    const USER_ALREADY_EXISTS = 10004;

    const SYSTEM_BUSY = 20000;
    const FORM_INPUT_INVALID = 20001;

    const PRODUCT_NOT_EXISTS = 30001;
    const PRODUCT_SOLD_OUT = 30002;

    protected static $details = [

        self::UNKNOWN => [
            "message" => "未知错误",
            "level" => EnumLoggerLevel::ERROR,
        ],
        
        self::USER_NOT_EXISTS => [
            "message" => "用户(%s)不存在，请核实后再试",
            "level" =>  EnumLoggerLevel::INFO,
        ],

        self::NEED_LOGIN => [
            "message" => "需要登录",
            "level" => EnumLoggerLevel::INFO,
        ],

        self::SYSTEM_BUSY => [
            "message" => "系统繁忙",
            "level" => EnumLoggerLevel::ERROR
        ],

        self::FORM_INPUT_INVALID => [
            "message" => "__DATA__%s",
            "level" => EnumLoggerLevel::INFO
        ],

        self::USER_ALREADY_EXISTS => [
            "message" => "用户资料(%s)已存在",
            "level"   => EnumLoggerLevel::INFO,
        ],

        self::PRODUCT_NOT_EXISTS => [
            "message" => "商品不存在",
            "level"   => EnumLoggerLevel::ERROR,
        ],

        self::PRODUCT_SOLD_OUT => [
            "message" => "商品已售空",
            "level"   => EnumLoggerLevel::ERROR,
        ],
        
    ];
   
    public static function exceptionClassPrefix()
    {
        return __NAMESPACE__ . "\\Exception\\";
    }
}
