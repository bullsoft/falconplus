<?php
namespace Demo\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class ProtoUser extends ProtoBuffer
{
    private $username;
    private $password;
    private $status = null;
    
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

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return \Demo\Protos\ProtoUser
     */
    public function setStatus(EnumUserStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @return \Demo\Protos\EnumUserStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}
