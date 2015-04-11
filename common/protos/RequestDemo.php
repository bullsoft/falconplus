<?php
namespace Demo\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class RequestDemo extends ProtoBuffer
{
    /**
     * @var string
     * @required
     */
    private $foo;

    /**
     * @var string
     * @required
     */
    private $bar;

    /**
     * @var \Demo\Protos\ProtoUser
     * @optional
     */
    private $user = null;

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

    public function setUser(\Demo\Protos\ProtoUser $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}
