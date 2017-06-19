<?php
namespace Demo\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Base\SimpleResponse as SimpleResponse;
use PhalconPlus\Db\UnitOfWork as UnitOfWork;
use Demo\Server\Models\DealRecord as DRModel;
use PhalconPlus\Assert\Assertion as Assert;

/**
 * Class DemoService
 * @package Demo\Server\Services
 */
class DealService extends BaseService
{
    public function getByDealNo(SimpleRequest $request)
    {
        $dealNo = $request->getParam("dealNo");
        $model = DRModel::findFirst([
            "dealNo = :dealNo:",
            "bind" => [
                "dealNo" => $dealNo,
            ]
        ]);
        if(empty($model)) {
            throw new \Exception("订单不存在");
        }
        return $model->toProtoBuffer();
    }
}