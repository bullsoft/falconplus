<?php
/* Code: */

require $rootPath."/common/load/default.php";

$di->setShared('cookie', function () {
    $cookie = new \Phalcon\Http\Response\Cookies();
    return $cookie;
});

$di->setShared('session', function () {
    $session = new \Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});

$di->set('flash', function () {
    $flash = new \Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-error',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
    ));
    return $flash;
});

// Pseudo-static Url
if(isset($_GET['_url'])) {
    $_GET['_url'] = str_replace(array('.html', '.htm', '.jsp', '.shtml'), '', $_GET['_url']);
}

// register rules for router
$di->set('router', function () use ($config) {
    $router = new \Phalcon\Mvc\Router(false);
    $router->removeExtraSlashes(true);

    $router->add('/:controller/([a-zA-Z0-9_\-]+)/:params', array(
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ))->convert('action', function ($action) {
        // return str_replace('-', '', $action);
        // transform action from foo-bar -> fooBar
        return lcfirst(Phalcon\Text::camelize($action));
    });
    $router->handle();
    return $router;
});

/* default-web.php ends here */
