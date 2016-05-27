<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/31
 * Time: 22:26
 */

namespace Plus\Web\Controllers;


class BlogController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $markdown = new \ParsedownExtra();
        $it = new \DirectoryIterator("glob://".APP_MODULE_DIR."public/blogs/*.md");
        $blogs = [];
        foreach($it as $f) {
            $basename = $f->getBasename(".md");
            $blogs[$basename]["ctime"] = $f->getCTime();
            $blogs[$basename]["owner"] = $f->getOwner();
            $blogs[$basename]["slug"]  = $basename;
            $blogs[$basename]["ctime"] = $f->getCTime();
            $content = file_get_contents($f->getPathname());
            preg_match('/^# (.*)/', $content, $matches);
            $blogs[$basename]["title"] = $matches[1];
            preg_match('/> (.*)/', $content, $matches);
            $blogs[$basename]["intro"] = $matches[1];
        }

        usort($blogs, function($a, $b){
            if ($a["ctime"] == $b["ctime"]) {
                return 0;
            }
            return ($a["ctime"] < $b["ctime"])? -1 : 1;
        });

        $pageSize = $this->request->getQuery("pageSize", "int", 5);
        $pageNo = $this->request->getQuery("pageNo", "int", 1);
        $pageSize = max(5, $pageSize);
        $pageNo = max(1, $pageNo);
        $total = count($blogs);
        $list = array_slice($blogs, ($pageNo-1)*$pageSize, $pageSize);
        $totalPage = ceil($total/$pageSize);
        $this->view->setVar("blogs", $list);
        $this->view->setVar("pageSize", $pageSize);
        $this->view->setVar("pageNo", $pageNo);
        $this->view->setVar("isLast", $pageNo >= $totalPage);
    }

    public function postAction($file)
    {
        $markdown = new \ParsedownExtra();
        $file = APP_MODULE_DIR."public/blogs/{$file}.md";
        $str = file_get_contents($file);
        $this->view->setVar("content",  $markdown->text($str));
    }
}