<?php
// Visiable Variables
// $rootPath       -- dir of the app
// $di             -- global di container
// $config         -- the \Phalcon\Config object
// $application    -- application object
// $loader         -- \Phalcon\Loader object
// $bootstrap      -- bootstrap object

return array(

    "application" => array(
        "debug"      => false,
        "close"      => false,
    ),

    'namespace' => array(
        'Assert'           => $rootPath.'/vendor/assert/lib/Assert/',
    ),
);


/* config.php ends here */
