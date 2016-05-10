<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/23
 * Time: 15:25
 */

namespace Demo\Server\Services;
use Demo\Server\Daos\CartDao;
use \PhalconPlus\Base\SimpleRequest;
use \PhalconPlus\Base\SimpleResponse;
use Demo\Server\Models\CartInfo;
use Demo\Server\Models\DealRecord;
use \PhalconPlus\Db\UnitOfWork;

class CartService extends BaseService
{
    public function getBySessionId(SimpleRequest $request)
    {
        $sessionId = $request->getParam(0);
        $cart = CartDao::getCart($sessionId)->toJson();
        $response = new SimpleResponse();
        $response->pushItem($cart);
        return $response;
    }

    /**
     * @param SimpleRequest $request
     * @throws \Common\Protos\Exception\ProductSoldOut
     */
    public function setItem(SimpleRequest $request)
    {
        $sessionId = $request->getParam(0);
        $skuId = $request->getParam(1);
        $qty = $request->getParam(2);
        $cart = CartDao::getCart($sessionId);
        $item = CartDao::newItem($skuId, $qty);
        $cart->setItem($item);
        $this->response->pushItem(CartDao::cache($cart));
        return $this->response;
    }

    public function delItem(SimpleRequest $request)
    {
        $sessionId = $request->getParam(0);
        $skuId = $request->getParam(1);
        $cart = CartDao::getCart($sessionId);
        $cart->unsetItem($skuId, false);
        return CartDao::cache($cart);
    }

    public function checkout(SimpleRequest $request)
    {
        $sessionId = $request->getParam(0);
        $userId = $request->getParam(1);
        $cart = CartDao::getCart($sessionId);
        $cartId = CartDao::generateId();

        $work = new UnitOfWork("dbDemo");

        foreach($cart->getItems() as $key => $item) {
            $cartInfo = new CartInfo();
            $cartInfo->uuid = $cartId;
            $cartInfo->sessionId = $sessionId;
            $cartInfo->skuId = $item->getId();
            $cartInfo->productId = $item->getVars()["product_id"];
            $cartInfo->userId = $userId;
            $cartInfo->sellerId = $item->getProvider();
            $cartInfo->price = $item->getPrice();
            $cartInfo->qty = $item->getQty();
            $work->save($key, $cartInfo);
        }

        $order = new DealRecord();
        $order->buyerId = $userId;
        $order->sellerId = 0;
        $order->cartUuid = $cartId;
        $order->amount = $cart->getTotals()["grand_total"];
        $work->save("order-".$cartId, $order);

        $work->exec();

        return $this->response;
        // CartDao::clear($sessionId);
    }

    public function clear(SimpleRequest $request)
    {
        $sessionId = $request->getParam(0);
        CartDao::remove($sessionId);
    }
}