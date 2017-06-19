<?php
namespace Demo\Server\Plugins;
use Phalcon\Mvc\User\Plugin as Plugin;

class RpcListener extends Plugin
{
    public function requestCheck($event, $server, $request)
    {
        error_log("!!!!Request Check: ... " .  var_export($request, true));

    }

    public function afterDispatch($event, $server, $mix)
    {
        error_log("After dispatcher: ... " .  var_export($mix, true));
    }
}