<?php
namespace Demo\Web\Controllers\Apis;

class BaseController extends \Demo\Web\Controllers\BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->view->disable();
    }
}