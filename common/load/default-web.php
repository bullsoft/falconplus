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

// register rules for router
$di->set('router', function () use ($config) {
    $router = new \Phalcon\Mvc\Router();
    $router->add('/:controller/:action/:params', array(
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ))->beforeMatch(function ($uri, $route) {
        // support '-' in controllers and actions
        $_GET['_url'] = str_replace('-', '', $_GET['_url']);
    });
    $router->handle();
    return $router;
});

/* default-web.php ends here */
