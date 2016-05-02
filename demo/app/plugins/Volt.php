<?php
namespace Demo\Web\Plugins;

class Volt
{
    public static function output($a, $b)
    {
        return $a . $b;
    }

    public static function test($a)
    {
        var_dump($a);
    }

    public function test1()
    {
        return "no parems";
    }
}