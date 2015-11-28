<?php
/* Code: */

use Phalcon\Logger\Adapter\File as FileLogger;

mb_internal_encoding("UTF-8");

// register global class-dirs, class-namespace and class-prefix
// $loader->registerDirs(array())->register();

$loader->registerNamespaces($config->namespace->toArray())->register();

// class autoloader
$di->setShared('loader', function () use ($loader) {
    return $loader;
});

// global config
$di->set('config', function () use ($config) {
    return $config;
});

// global logger
$di->set('logger', function () use ($config) {
    try {
        $logger = new FileLogger($config->application->logFilePath);
        return $logger;
    } catch (\Exception $e) {
        throw $e;
    }
}, true);

$di->setShared('modelsManager', function() {
    return new \Phalcon\Mvc\Model\Manager();
});

// global funciton to retrive $di
if (!function_exists("getDI")) {
    function getDI()
    {
        return \Phalcon\DI::getDefault();
    }
}

if (!function_exists("getRealSql")) {
    function getRealSql(\Phalcon\Db\Adapter\Pdo\Mysql $db)
    {
        $sql = $db->getSQLStatement();
        $vars = $db->getSQLVariables();
        if ($vars) {
            $keys = array();
            $values = array();
            foreach ($vars as $placeHolder=>$var) {
                // fill array of placeholders
                if (is_string($placeHolder)) {
                    $keys[] = '/:'.ltrim($placeHolder, ':').'/';
                } else {
                    $keys[] = '/[?]/';
                }
                // fill array of values
                // It makes sense to use RawValue only in INSERT and UPDATE queries and only as values
                // in all other cases it will be inserted as a quoted string
                if ((strpos($sql, 'INSERT') === 0 || strpos($sql, 'UPDATE') === 0) && $var instanceof \Phalcon\Db\RawValue) {
                    $var = $var->getValue();
                } elseif (is_null($var)) {
                    $var = 'NULL';
                } elseif (is_numeric($var)) {
                    $var = $var;
                } else {
                    $var = '"'.$var.'"';
                }
                $values[] = $var;
            }
            $sql = preg_replace($keys, $values, $sql, 1);
        }
        return $sql;

    }
}

/* default.php ends here */
