<?php
/* default-cli.php ---
 *
 * Filename: default-cli.php
 * Description:
 * Author: Gu Weigang
 * Maintainer:
 * Created: Tue Jan 29 14:55:44 2013 (+0800)
 * Version: master
 * Last-Updated: Wed Nov 27 12:10:20 2013 (+0800)
 *           By: Gu Weigang
 *     Update #: 27
 *
 */

/* Code: */

require $rootPath."/common/load/default.php";

$di->set('router', function() {
        $router = new \Phalcon\CLI\Router();
        return $router;
});

$di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\CLI\Dispatcher();
        $dispatcher->setDI($di);
        return $dispatcher;
});

/* default-cli.php ends here */
