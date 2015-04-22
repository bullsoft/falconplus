namespace {{rootNs}}\Server\Services;
use PhalconPlus\Base\SimpleRequest as SimpleRequest;

class DummyService extends \PhalconPlus\Base\Service
{
    public function demo(SimpleRequest $request)
    {
    	return $reqeust->toArray();
    }
}