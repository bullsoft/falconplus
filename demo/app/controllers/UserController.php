<?php
namespace Demo\Web\Controllers;

use Common\Protos\ProtoRegInfo;
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

        // $this->session->set('identity', $response->getMobile());

        return $response;
    }

    public function webCreateAction()
    {

    }

    /**
     * @disableView
     */
    public function doCreateAction()
    {
        $form = new Form();
        // 手机号
        $mobile = new Text("mobile");
        $mobile->addValidator(new PresenceOf(array(
            'message' => '手机号不能为空',
        )));
        $mobile->addValidator(new RegexValidator(array(
            'pattern' => '/^[1][3578]\d{9}$/',
            'message' => '手机号码格式不正确'
        )));

        // 邮箱
        $email = new Text("email");
        $email->addValidator(new PresenceOf(array(
            'message' => '邮箱地址不能为空',
        )));
        $email->addValidator(new EmailValidator(array(
            'message' => '邮箱格式不正确'
        )));

        // 密码
        $passwd = new Text("passwd");
        $passwd->addValidator(new PresenceOf(array(
            'message' => '密码不能为空',
        )));
        $passwd->addValidator(new StringLength(array(
            'max' => 12,
            'min' => 8,
            'messageMaximum' => '密码长度不能超过 36 ',
            'messageMinimum' => '密码长度不能小于 8 '
        )));
        $passwd->addValidator(new RegexValidator(array(
            "pattern" => '#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#',
            "message" => "密码强度不够"
        )));


        $form->add($mobile)
             ->add($email)
             ->add($passwd);

        $this->formValid($form, $_POST);

        $regInfo = new ProtoRegInfo();
        $regInfo->setMobile($mobile->getValue())
                ->setPasswd($passwd->getValue())
                ->setEmail($email->getValue());

        $inviteCode = $this->request->getPost("inviteCode", "alphanum");
        if(!empty($inviteCode)) {
            $regInfo->setInviteCode($inviteCode);
        }

        $response = $this->rpc->callByObject(array(
            "service" => "\\Demo\\Server\\Services\\User",
            "method" => "create",
            "args" => $regInfo,
            "logId" => $this->logger->getFormatter()->uid,
        ));

        var_dump($response);
    }
}