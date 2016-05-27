<?php
namespace Demo\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;
use PhalconPlus\Base\SimpleResponse as SimpleResponse;

/**
 * Class DemoService
 * @package Demo\Server\Services
 */
class SeqGenService extends BaseService
{
    private $seq = null;

    public function onConstruct()
    {
        parent::onConstruct();
        $this->seq = new \BullSoft\Seq($this->getDI()->getConfig()->dbDemo,
                                       $this->getDI()->getConfig()->redis);
    }

    public function create(SimpleRequest $request)
    {
        $app = $request->getParam(0);
        $bucket = $request->getParam(1);
        $start = $request->getParam(2);
        $this->response->setResult($this->seq->create($app, $bucket, $start));
        return $response;
    }

    public function generate(SimpleRequest $request)
    {
        $app = $request->getParam(0);
        $bucket = $request->getParam(1);
        $start = $request->getParam(2);
        $this->response->setResult($this->seq->generate($app, $bucket, $start));
        return $this->response;
    }
}