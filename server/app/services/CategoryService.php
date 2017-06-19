<?php

namespace Demo\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Base\SimpleResponse as SimpleResponse;
use PhalconPlus\Db\UnitOfWork as UnitOfWork;
use BullSoft\Category as C;
use Demo\Server\Models\CategoryField as CFModel;
use PhalconPlus\Assert\Assertion as Assert;

/**
 * Class DemoService
 * @package Demo\Server\Services
 */
class CategoryService extends BaseService
{
    /**
     * @var \BullSoft\Category
     */
    protected $cate = null;

    protected function onConstruct()
    {
        parent::onConstruct();
        $this->cate = new C($this->getDI()->get('dbDemo'));
    }

    public function getTops()
    {
        $result = $this->cate->getTops();
        $this->response->setResult($result);
        return $this->response;
    }

    public function getFieldsByCateId(SimpleRequest $request)
    {
        $cateId = $request->getParam(0);
        Assert::numeric($cateId);
        $collection = CFModel::find(["cateId = :ci:",
                                     "bind" => [
                                         "ci" => $cateId,
                                     ]
        ]);
        $this->response->setResult($collection->toArray());
        return $this->response;
    }

    public function getOptionFieldsByCateId(SimpleRequest $request)
    {
        $cateId = $request->getParam(0);
        Assert::numeric($cateId);
        $collection = CFModel::find(["cateId = :ci: AND inputType = :it:",
                                "bind" => [
                                    "ci" => $cateId,
                                    "it" => 'OPTION',
                                ]
        ]);
        $this->response->setResult($collection->toArray());
        return $this->response;
    }

    public function getById()
    {

    }


    public function getChildrenByParentId()
    {

    }

    public function add()
    {

    }
}
