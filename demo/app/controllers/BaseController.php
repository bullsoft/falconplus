<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/13
 * Time: 14:00
 */

namespace Demo\Web\Controllers;


class BaseController extends \Phalcon\Mvc\Controller
{
    protected $controller;
    protected $action;

    public function initialize()
    {
        $this->controller = $whichController = $this->dispatcher->getControllerName();
        $this->action = $whichAction = $this->dispatcher->getActionName();

        $titles = $this->di->get("siteConf");

        $this->view->setVar("whichController", $whichController);
        $this->view->setVar("whichAction", strtolower($whichAction));
        $this->view->setVar("title", $titles->get("{$whichController}:{$whichAction}", "网站标题"));
        $this->view->setVar("headDesc", $titles->get("headDesc", "网站描述"));
        $this->view->setVar("headKeywords", $titles->get("headKeywords", "网站关键词"));

        $this->view->setVar("tpl",  $titles->get("template", "dianrong"));
        $this->view->setVar("version", date("Ymd").rand(10000, 99990));

    }

    protected function formValid(\Phalcon\Forms\Form $form, array $input)
    {
        if(!$form->isValid($input)) {
            $details = [];
            foreach ($form->getMessages() as $val) {
                $details[$val->getField()][] = $val->getMessage();
            }
            $msg = "{$this->controller}:{$this->action} form failed to validate";
            throw new \Common\Protos\Exception\FormInputInvalid([$msg, json_encode($details, \JSON_UNESCAPED_UNICODE)], $this->logger);
        }
        return true;
    }
}