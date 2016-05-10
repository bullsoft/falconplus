<?php
namespace Demo\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Base\SimpleResponse as SimpleResponse;

class BaseService extends \PhalconPlus\Base\Service
{
    /**
     * @var \PhalconPlus\Base\SimpleResponse
     */
    protected $response = null;

    protected function onConstruct()
    {
        $this->response = new SimpleResponse();
    }
}