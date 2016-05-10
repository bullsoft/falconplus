<?php
namespace Demo\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Base\SimpleResponse as SimpleResponse;
use PhalconPlus\Db\UnitOfWork as UnitOfWork;
use PhalconPlus\Assert\Assertion as Assert;
use Demo\Server\Daos\ProductDao;
/**
 * Class DemoService
 * @package Demo\Server\Services
 */
class SkuService extends BaseService
{
    public function getByCateId(SimpleRequest $request)
    {
        $cateId = $request->getParam(0);
        $pagable = $request->getParam(1);
        $result = ProductDao::getByCateId($cateId, $pagable->getPageNo(), $pagable->getPageSize());
        $this->response->setResult($result);
        return $this->response;
    }
}