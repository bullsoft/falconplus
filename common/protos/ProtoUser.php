<?php
namespace Demo\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class ProtoUser extends ProtoBuffer
{
    private $username;
    private $password;

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
