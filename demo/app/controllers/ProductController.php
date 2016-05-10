<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/27
 * Time: 14:50
 */

namespace Demo\Web\Controllers;


class ProductController extends BaseController
{
    /**
     * 商品详情页
     */
    public function webItemAction()
    {

    }

    public function listAction()
    {
        $tops = $this->rpc("Category", "getTops");
        $this->view->setVar("tops", $tops->getResult());
        if($this->request->getQuery("type")) {
            $type = $this->request->getQuery("type", "string", "p2p");
            $cateId = $this->request->getQuery("id", "int", 2);
        } else {
            $type = "p2p";
            $cateId = 2;
        }
        $fields = $this->rpc("Category", "getFieldsByCateId", [$cateId]);
        $fieldsArray = $fields->getResult();
        $fieldsWithIdKey = [];
        foreach($fieldsArray as $field) {
            $fieldsWithIdKey[$field['id']] = $field;
        }
        $this->view->setVar("fields", $fieldsWithIdKey);

        $pageNo = $this->request->getQuery("pageNo", "int", 1);
        $pageSize = $this->request->getQuery("pageSize", "int", 10);

        $pageNo = max(1, $pageNo);
        $pageSize = max(10, $pageSize);

        $pagable = new \PhalconPlus\Base\Pagable();
        $pagable->setPageSize($pageSize);
        $pagable->setPageNo($pageNo);
        $skus = $this->rpc("Sku", "getByCateId", [$cateId, $pagable]);
        //var_dump($skus->getResult());exit;
        $this->view->setVar("skus", $skus->getResult());
    }

    public function webRankingAction()
    {

    }

    public function webRecommendAction()
    {

    }

    /**
     * 商品评星接口
     * @disableView
     * @api
     * @disableGuest
     */
    public function doStarAction()
    {

    }


    /**
     * 商品评论接口
     * @api
     * @disableView
     */
    public function doCommentListAction()
    {

    }

    /**
     * @disableView
     * @api
     * @disableGuest
     */
    public function doCommentAction()
    {

    }
}