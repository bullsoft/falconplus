<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/8/2
 * Time: 16:06
 */
namespace Demo\Admin\Web\Controllers;

class UserController extends BaseController
{
    /**
     * 模板使用示例
     */
    public function indexAction()
    {
        echo "It works.";
    }


    public function loginAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

    public function listAction()
    {

    }

    public function createAction()
    {
        $this->jsFooter
            ->addJs('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')
            ->addJs('assets/global/plugins/jquery-validation/js/additional-methods.min.js')
            ->addJs('assets/pages/scripts/form-validation-md.min.js');
    }
}