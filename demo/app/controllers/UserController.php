<?php
namespace Demo\Web\Controllers;

use \PhalconPlus\Base\SimpleRequest;

use Common\Protos\ProtoLoginInfo;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Regex as RegexValidator;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Between as BetweenValidator;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\InclusionIn as InclusionInValidator;
use Phalcon\Validation\Validator\Url as UrlValidator;


class UserController extends BaseController
{
    public function indexAction()
    {
        $request = new SimpleRequest();
        $request->setParam("foo");
        $request->setParam("bar");
        $response = $this->ucRpc->callByObject(array(
            "service" => "\\UCenter\\Srv\\Services\\Dummy",
            "method" => "demo",
            "args" => $request,
        ));

        var_dump($response);
    }

    public function dAction()
    {
        $this->session->destroy();
        echo "OK";
    }

    public function webLoginAction()
    {

    }

    /**
     * @disableView
     */
    public function doLoginAction()
    {
        $form = new Form();
        $mobile = new Text("mobile");
        $passwd = new Text("passwd");
        $mobile->addValidator(
            new PresenceOf([
                'message' => "手机号不能为空",
            ])
        );
        $passwd->addValidator(
            new PresenceOf([
                'message' => "密码不能为空"
            ])
        );
        $form->add($mobile)
             ->add($passwd);

        $this->formValid($form, $_POST);

        $loginInfo = new ProtoLoginInfo();
        $loginInfo->setMobile($mobile->getValue())
                  ->setPasswd($passwd->getValue());

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\User",
            "method" => "passwdMatch",
            "args" => $loginInfo,
            "logId" => $this->logger->getFormatter()->uid,
        ));

        $this->session->set('identity', $response->getMobile());

        return $response;
    }

    public function webCreateAction()
    {
        $form = new Form();
        $mobile = new Text("mobile");
        $mobile->addValidator('mobile', new RegexValidator(array(
            'pattern' => '/^[1][3578]\d{9}$/',
            'message' => '手机号码格式不正确'
        )));
        $form->add($mobile);
    }

    /**
     * @disableView
     */
    public function doCreateAction()
    {

    }
}