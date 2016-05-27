<?php
namespace Plus\Web\Controllers;

class ErrorController extends \Phalcon\Mvc\Controller
{
    public function show404Action()
    {
        echo '<div class="jumbotron"><h1><span class="error-404">404</span></h1>';
        echo "<p>The URI you requested is not exist: <i>" . $_GET["_url"] . "</i></p></div>";
    }

    public function showUnknownAction()
    {
        $e = $this->dispatcher->getParams()[0];
        echo "<h1>Whoops!</h1>";
        echo "<p>ErrorCode: " . $e->getCode() . "</p>";
        echo "<p>ErrorMessage: " . $e->getMessage() . "</p>";
    }
}