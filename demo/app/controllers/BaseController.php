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
    public function initialize()
    {
        $whichController = $this->dispatcher->getControllerName();
        $whichAction = $this->dispatcher->getActionName();

        $siteTitle = include_once(APP_MODULE_DIR . "app/config/siteTitle.php");
        $titles = new \Phalcon\Config($siteTitle);

        $this->view->setVar("whichController", $whichController);
        $this->view->setVar("whichAction", $whichController);
        $this->view->setVar("title", $titles->get("{$whichController}:{$whichAction}", "网站标题"));
        $this->view->setVar("headDesc", $titles->get("headDesc", "网站描述"));
        $this->view->setVar("headKeywords", $titles->get("headKeywords", "网站关键词"));
        $this->view->setVar("tpl",  $titles->get("template", "dianrong"));
        $this->view->setVar("version", date("Ymd").rand(10000, 99990));

    }

    protected function formValid(\Phalcon\Forms\Form $form, $input)
    {
        if(!$form->isValid($input)) {
            $details = [];
            foreach ($form->getMessages() as $val) {
                $details[$val->getField()] = $val->getMessage();
            }
            throw new \Common\Protos\Exception\FormInputInvalid(["json", json_encode($details)], $this->logger);
        }
        return true;
    }
}