<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/27
 * Time: 18:20
 */

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

class CartController extends BaseController
{
    public function webIndexAction()
    {
        $sessionId = $this->session->getId();
        $request = new SimpleRequest();
        $request->setParam($sessionId);

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Cart",
            "method" => "getBySessionId",
            "args" => $request,
            "logId" => $this->logger->getFormatter()->uid,
        ));
        $json = $response->popItem();
        $cart = new BsCart\Cart();
        $cart->importJson($json);
        $this->view->setVar("cart", $cart);
    }

    /**
     * @api
     * @disableView
     *
     * @return mixed
     * @throws \Common\Protos\Exception\FormInputInvalid
     */
    public function doSetItemAction()
    {
        $form = new Form();
        $skuId = new Text("skuId");
        $qty = new Text("qty");

        $skuId->addValidator(new PresenceOf(array(
            "message" => "产品不能为空哦",
        )));
        $qty->setFilters("int");
        $qty->addValidator(new DigitValidator(array(
            "message" => "数量必须是整数哦",
        )));
        $qty->addValidator(new BetweenValidator(array(
            "minimum" => 1,
            "maximum" => 100,
            "message" => "数量必须要大于0哦",
        )));

        $form->add($skuId)
             ->add($qty);

        $this->formValid($form, $_POST);

        $request = new SimpleRequest();
        $request->setParam($this->session->getId());
        $request->setParam($skuId->getValue());
        $request->setParam($qty->getValue());

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Cart",
            "method" => "setItem",
            "args" => $request,
            "logId" => $this->logger->getFormatter()->uid,
        ));

        return $response;
    }

    /**
     * @api
     * @disableView
     *
     * @throws \Common\Protos\Exception\FormInputInvalid
     */
    public function doRmItemAction()
    {
        $form = new Form();
        $skuId = new Text("skuId");
        $skuId->addValidator(new PresenceOf(array(
            "message" => "产品不能为空哦",
        )));

        $form->add($skuId);
        $this->formValid($form, $_POST);

        $request = new SimpleRequest();
        $request->setParam($this->session->getId());
        $request->setParam($skuId->getValue());

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Cart",
            "method" => "delItem",
            "args" => $request,
            "logId" => $this->logger->getFormatter()->uid,
        ));

        return $response;
    }


    public function doRmAllAction()
    {
    }

    /**
     * @api
     * @disableView
     * @disableGuest
     */
    public function doCheckoutAction()
    {
        $request = new SimpleRequest();
        $request->setParam($this->session->getId());
        $request->setParam($this->session->get("identity"));

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\Cart",
            "method" => "checkout",
            "args" => $request,
            "logId" => $this->logger->getFormatter()->uid,
        ));

        return $response;
    }
}