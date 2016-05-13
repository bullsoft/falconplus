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
        $orderId = $this->request->getQuery("orderId");
    }

    public function paymentAction()
    {

    }

    public function callbackActin()
    {

    }
}