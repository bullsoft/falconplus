<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/25
 * Time: 19:31
 */

namespace Demo\Web\Controllers;


class CateController extends BaseController
{
    public function addAction()
    {
        $cate = new \BullSoft\Category($this->di->get('dbDemo'));
        $cate->add("电商", 1);
    }
}