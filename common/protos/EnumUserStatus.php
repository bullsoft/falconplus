<?php
namespace Demo\Protos;
use \PhalconPlus\Enum\AbstractEnum;

class EnumUserStatus extends AbstractEnum
{
    const __default = 0;

    const NORMAL = 0;
    const INIT = 1;
    const NEED_VALID = 2;
    const BLOCK = 3;
    const DELETED = 4;
}