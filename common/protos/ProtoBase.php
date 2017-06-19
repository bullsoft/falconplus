<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/14
 * Time: 18:41
 */

namespace Common\Protos;
use \PhalconPlus\Base\ProtoBuffer;

class ProtoBase extends ProtoBuffer
{
    const NULL_VALUE = "__PhalconPlus_ProtoBuffer_NullValue__";

    public function isNull($property)
    {
        if(!property_exists($this, $property)) {
            throw new \Exception("Property {$property} not exists in Class ". get_called_class());
        }
        return $this->{$property} == self::NULL_VALUE;
    }
}