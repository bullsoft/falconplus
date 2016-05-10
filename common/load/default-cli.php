<?php
/* html-cli.php ---
 *
 * Filename: html-cli.php
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

require $rootPath."/common/load/html.php";

$di->set('router', function() {
        $router = new \Phalcon\CLI\Router();
        return $router;
});

$di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\CLI\Dispatcher();
        $dispatcher->setDI($di);
        return $dispatcher;
});

/* html-cli.php ends here */
