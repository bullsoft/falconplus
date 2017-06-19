<?php
namespace BullSoft\Cart;

class Factory 
{

    /**
     * Create Cart
     */
    static function createCartFromEntity($entity)
    {
        $cart = new Cart();		
        $cart->importJson($entity->getJson());
        return $cart;
    }

    /**
     * Create Item
     */
    static function createItemFromEntity($entity, $qty = 1)
    {
        $item = new Item();
        $item->setId($entity->getId())
            ->setSku($entity->getSku())
            ->setName($entity->getName())
            ->setPrice($entity->getPrice())
            ->setQty($qty)
            ->setIsDiscountable($entity->getIsDiscountable())
            ->setIsTaxable($entity->getIsTaxable())
            ;

        return $item;
    }

    /**
     * Create Discount, with applicable DiscountConditions
     */
    static function createDiscountFromEntity($entity)
    {
        $discount = new Discount();
        $discount->setId($entity->getId())
                ->setName($entity->getName())
                ->setAs($entity->getAppliedAs())
                ->setTo($entity->getAppliedTo())
                ->setValue($entity->getValue())
                ->setIsPreTax($entity->getIsPreTax())
                ->setIsAuto($entity->getIsAuto())
                ->setCouponCode($entity->getCouponCode())
                ;

        //TODO: build discount conditions

        return $discount;
    }

    /**
     * Create Shipment
     */
    static function createShipmentFromEntity($entity, $price = null)
    {
        $price = (float) (is_null($price)) ? $entity->getPrice() : $price;

        $shipment = new Shipment();
        $shipment->setId($entity->getId())
                ->setPrice($price)
                ->setIsDiscountable($entity->getIsDiscountable())
                ->setIsTaxable($entity->getIsTaxable())
                ;

        return $shipment;
    }

    /**
     * Create DiscountCondition
     */
    static function createDiscountConditionFromEntity($entity)
    {
        $discountCondition = new DiscountCondition();
        $discountCondition->setId($entity->getId())
                        ->setName($entity->getName())
                        ->setCompareType($entity->getCompareType())
                        ->setCompareValue($entity->getCompareValue())
                        ->setSourceEntityType($entity->getSourceEntityType())
                        ->setSourceEntityField($entity->getSourceEntityField())
                        ->setSourceEntityFieldType($entity->getSourceEntityFieldType())
                        ;

        return $discountCondition;
    }

}
