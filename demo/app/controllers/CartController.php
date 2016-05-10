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
    public function indexAction()
    {
        $sessionId = $this->session->getId();
        $response = $this->rpc("Cart", "getBySessionId", [$sessionId]);
        $json = $response->popItem();
        $cart = new BsCart\Cart();
        $cart->importJson($json);
        $this->view->setVar("cart", $cart);
    }
}