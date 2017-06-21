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
            preg_match('/标签（空格分隔）： (.*)/', $content, $matches);
            $blogs[$basename]["tags"] = explode(" ", $matches[1]);
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
        $randKey = array_rand($this->config->sayings->toArray(), 1);
        $this->view->setVar("saying", $this->config->sayings[$randKey]);
    }

    public function postAction($file)
    {
        $randKey = array_rand($this->config->sayings->toArray(), 1);
        $file = APP_MODULE_DIR."public/blogs/{$file}.md";
        $randKey = array_rand($this->config->sayings->toArray(), 1);
        $this->view->setVar("saying", $this->config->sayings[$randKey]);
        if(!file_exists($file)) {
            throw new \Exception("该文章不存在", 1112);
        }
        $str = file_get_contents($file);
        $markdown = new \ParsedownExtra();
        $this->view->setVar("content",  $markdown->text($str));
        $this->view->setVar("saying", $this->config->sayings[$randKey]);
    }

    public function searchAction()
    {
        $query = $this->request->getQuery("query");
        if(empty($query)) {
            echo "empty";
            exit;
        }
        $search = escapeshellarg($query);
        $dir = APP_MODULE_DIR. "public/blogs/*.md";
        $cmd = escapeshellcmd("grep -rianl {$search} ")  . $dir;
        $result = exec($cmd, $files);
        if(!empty($files)) {
            $markdown = new \ParsedownExtra();
            $blogs = [];
            foreach($files as $file) {
                if(!file_exists($file)) {
                    continue;
                }
                $f = new \SplFileObject($file);
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
                preg_match('/标签（空格分隔）： (.*)/', $content, $matches);
                $blogs[$basename]["tags"] = explode(" ", $matches[1]);
                $basename = basename($file, ".md");
                $content = file_get_contents($file);
                preg_match('/^# (.*)/', $content, $matches);
            }
        } else {
            //echo "搜索结果为空... ";
        }
        $this->view->setVar("blogs", $blogs);
    }
}