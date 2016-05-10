<?php
namespace Demo\Web\Controllers\Apis;

class TestController extends BaseController
{
    public function mainAction()
    {
        return ["hello", "world"];
    }
}