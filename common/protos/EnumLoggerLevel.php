<?php
namespace Demo\Protos;
use \PhalconPlus\Enum\AbstractEnum;

class EnumLoggerLevel extends AbstractEnum
{
    const __default = self::DEBUG;

    const DEBUG   = \Phalcon\Logger::DEBUG;   // 7
    const INFO    = \Phalcon\Logger::INFO;    // 6
    const NOTICE  = \Phalcon\Logger::NOTICE;  // 5
    const WARNING = \Phalcon\Logger::WARNING; // 4
    const ERROR   = \Phalcon\Logger::ERROR;   // 3
    const ALERT   = \Phalcon\Logger::ALERT;   // 2
}