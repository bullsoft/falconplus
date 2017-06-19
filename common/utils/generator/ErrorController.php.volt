namespace {{rootNs}}\Web\Controllers;

class ErrorController extends \Phalcon\Mvc\Controller
{
    public function show404Action()
    {
        echo "<h1>404, Not Found!</h1>";
        echo "<p>The URI you requested is not exist: <i>" . $_GET["_url"] . "</i>"; 
    }

    public function showUnknownAction()
    {
        $e = $this->dispatcher->getParams()[0];
        echo "<h1>Whoops!</h1>";
        echo "<p>ErrorCode: " . $e->getCode() . "</p>";
        echo "<p>ErrorMessage: " . $e->getMessage() . "</p>";
    }
}
