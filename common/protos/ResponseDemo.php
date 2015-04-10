<?php
namespace Demo\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class ResponseDemo extends ProtoBuffer
{
    private $result;

    public function setResult($a)
    {
        $this->result = $a;
    }

    public function getResult()
    {
        return $this->result;
    }
}
