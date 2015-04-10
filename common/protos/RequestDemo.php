<?php
namespace Demo\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class RequestDemo extends ProtoBuffer
{
    private $foo;
    private $bar;

    public function setFoo($a)
    {
        $this->foo = $a;
        return $this;
    }

    public function getFoo()
    {
        return $this->foo;
    }

    public function setBar($b)
    {
        $this->bar = $b;
        return $this;
    }

    public function getBar()
    {
        return $this->bar;
    }
}
