<?php
namespace Demo\Web\Controllers\Apis;

use PhalconPlus\Base\SimpleRequest;
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

class CartController extends BaseController
{
    /**
     * @api
     * @disableView
     *
     * @return mixed
     * @throws \Common\Protos\Exception\FormInputInvalid
     */
    public function setItemAction()
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
            "maximum" => 10000000,
            "message" => "数量必须要大于0哦",
        )));

        $form->add($skuId)
            ->add($qty);

        $this->formValid($form, $_POST);

        $request = new SimpleRequest();
        $request->setParam($this->session->getId());
        $request->setParam($skuId->getValue());
        $request->setParam($qty->getValue());

        $response = $this->rpc("Cart", "setItem", $request);
        return $response;
    }

    /**
     * @api
     * @disableView
     *
     * @throws \Common\Protos\Exception\FormInputInvalid
     */
    public function rmItemAction()
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


    public function rmAllAction()
    {
    }

    /**
     * @api
     * @disableView
     * @disableGuest
     */
    public function checkoutAction()
    {
        $response = $this->rpc("Cart", "checkout", [$this->session->getId(), $this->session->get("identity")]);
        return $response;
    }
}