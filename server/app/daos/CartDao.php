<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/23
 * Time: 13:35
 */

namespace Demo\Server\Daos;
use BullSoft\Cart as BsCart;
use Demo\Server\Models\SkuInfo;
use BullSoft\UUID;
use Common\Protos\Exception\ProductNotExists;
use Common\Protos\Exception\ProductSoldOut;

class CartDao
{
    const KEY = "cart";

    public static function generateId()
    {
        $u4 = UUID::v4();
        $u5 = UUID::v5($u4, self::KEY);
        return $u5;
    }

    private static function getCacheKey($sessionId)
    {
        return self::KEY . ":" . $sessionId;
    }

    public static function getCart($sessionId)
    {
        $redis = getDI()->get("redis");
        $json = $redis->get(self::getCacheKey($sessionId));
        $cart = self::newCart($sessionId);
        if($json) {
            $cart->importJson($json);
        }
        return $cart;
    }

    public static function newCart($sessionId)
    {
        $cart = new BsCart\Cart();
        $cart->setId($sessionId);
        return $cart;
    }

    public static function getById($skuId)
    {
        $skuInfo = SkuInfo::findFirst($skuId);
        if(empty($skuInfo)) {
            throw new ProductNotExists("{$skuId} not exists");
        }
        return $skuInfo;
    }

    public static function newItem($skuId, $qty = 1)
    {
        $skuInfo = self::getById($skuId);
        if($skuInfo->amount <= 0) {
            throw new ProductSoldOut("{$skuId} sold out");
        }
        $item = new BsCart\Item();
        $item->setId($skuInfo->id)
            ->setProvider($skuInfo->sellerId)
            ->setQty($qty)
            ->setName($skuInfo->name)
            ->setVar('product_id', $skuInfo->productId)
            ->setVar('amount', $skuInfo->amount)
            ->setPrice($skuInfo->price)
            ->setIsTaxable(true)
            ->setIsDiscountable(true);
        return $item;
    }

    public static function cache(BsCart\Cart $cart)
    {
        $redis = getDI()->get("redis");
        $json = $cart->toJson();
        $sessionId = $cart->getId();
        return $redis->setEx(self::getCacheKey($sessionId), 4*3600, $json);
    }

    public static function clear($sessionId)
    {
        $redis = getDI()->get("redis");
        return $redis->delete(self::getCacheKey($sessionId));
    }
}