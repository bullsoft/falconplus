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
        'BullSoft'  => $rootPath.'/common/vendor/BullSoft/',
    ),
);


/* config.php ends here */
