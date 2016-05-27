<?php
namespace Demo\Web\Controllers;
use \PhalconPlus\Base\SimpleRequest;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Between as BetweenValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\InclusionIn as InclusionInValidator;
use Phalcon\Validation\Validator\Url as UrlValidator;
use Phalcon\Validation\Validator\Digit as DigitValidator;

use BullSoft\Cart as BsCart;

class OrderController extends BaseController
{
    public function indexAction()
    {

    }

    public function paymentAction($type)
    {
        $type = new \Common\Protos\EnumPaySP($type);
        $orderNo = $this->request->getQuery("orderNo");
        $order = $this->rpc("Deal", "getByDealNo", ["dealNo" => $orderNo]);

        $gateway = \Omnipay\Omnipay::create('Alipay_Express');
        $gateway->setPartner('208800246512343434343');
        $gateway->setKey('sdfasdfaf');
        $gateway->setSellerEmail('cnwggu@gmail.com');
        $gateway->setReturnUrl('http://www.shopbigbang.com/order/return');
        $gateway->setNotifyUrl('http://www.shopbigbang.com/order/notify');

        // For 'Alipay_MobileExpress', 'Alipay_WapExpress'
        // $gateway->setPrivateKey('/such-as/private_key.pem');
        $options = [
            'out_trade_no' => $orderNo, // your site trade no, unique
            'subject'      => "测试购买东西", // order title
            'total_fee'    => '0.01', // order total fee
        ];
        $response = $gateway->purchase($options)->send();
        $this->view->setVar("redirectUrl", $response->getRedirectUrl());

        //var_dump($response->getRedirectData());
        //exit;
        //For 'Alipay_MobileExpress'
        //Use the order string with iOS or Android SDK
        //$response->getOrderString();
    }

    public function checkoutAction()
    {
        $id = $this->request->getQuery("id");
        $hashids = new \Hashids\Hashids('helloworld');
        $data = $hashids->decode($id);
        $order = $this->rpc("Deal", "getByDealNo", ["dealNo" => reset($data)]);
        $this->view->setVar("order", $order->toArray());

        $skuInfo = $this->rpc("Sku", "getByIds", ['ids' => array_column($order->relatedCartDetails, "skuId")]);
        $this->view->setVar("skus", $skuInfo->toArray()['result']);
    }

    public function returnAction()
    {

    }

    public function notifyActin()
    {

    }
}