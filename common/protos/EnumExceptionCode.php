<?php
namespace Demo\Protos;
use \PhalconPlus\Enum\AbstractEnum;
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
class EnumExceptionCode extends AbstractEnum
{
    const __default = self::UNKNOWN;

    /**
     * 请不要使用重复异常码
     */
    const UNKNOWN = 10000;
    const USER_NOT_EXISTS = 10001;
    const AUTH_FAILED = 10002;
    const NEED_LOGIN = 10003;

    private static $details = [

        self::UNKNOWN => [
            "message" => "未知错误",
            "level" => EnumLoggerLevel::ERROR,
        ],
        
        self::USER_NOT_EXISTS => [
            "message" => "用户不存在，请核实后再试",
            "level" =>  EnumLoggerLevel::INFO,
        ],
        
    ];
    
    public static function has(EnumExceptionCode $code)
    {
        return isset(self::$details[$code->__toString()]);
    }
    
    public static function getByCode(EnumExceptionCode $code)
    {
        $detail = [];
        if(self::has($code)) {
            $detail = self::$details[$code->__toString()];
            $detail["code"] = $code->__toString();
        }
        return $detail;
    }

    public static function newException($eCode)
    {
        Assert::notEmpty($eCode);
        $code = new self($eCode);
        $codeMap2Name = array_flip(self::validValues(true));
        $eName = $codeMap2Name[$eCode];
        // USER_NOT_EXISTS -> \Demo\Protos\ExceptionUserNotExists
        $eClassName = __NAMESPACE__."\\Exception".\Phalcon\Text::camelize($eName); 
        $exception = new $eClassName($code->getMessage());
        $exception->setCode($code->getCode());
        $exception->setLevel($code->getLevel());
        return $exception;
    }

    public function getMessage()
    {
        return self::$details[$this->getValue()]["message"];
    }

    public function getLevel()
    {
        return self::$details[$this->getValue()]["level"];
    }

    public function getCode()
    {
        return $this->getValue();
    }
}