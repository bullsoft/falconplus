<?php
ini_set("memory_limit", "4G");

/**
 * @param string $input
 */
function invoke($input)
{
    $bootstrap = new \PhalconPlus\Bootstrap(dirname(dirname(__DIR__)));
    $di = new \Phalcon\DI\FactoryDefault\CLI();
    $di->set("dispatcher", function() {
        $disptcher = new \Phalcon\CLI\Dispatcher();
        return $disptcher;
    });
    $di->set("dispatched", function() {
        return true;
    });
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(__DIR__))
           ->register();
    $argv = $GLOBALS["argv"];
    $arguments = array();
    foreach($argv as $k => $arg) {
        if($k == 2) {
            $arguments['task'] = $arg;
        } elseif($k == 3) {
            $arguments['action'] = $arg;
        } elseif($k >= 4) {
            $arguments['params'][] = $arg;
        }
    }
    if(!isset($arguments['action'])) {
        $arguments['action'] = "main";
    }
    $arguments['params'][] = $input;
    $bootstrap->execTask($arguments, $di);
}

function generate() // -> array
{
    $bootstrap = new \PhalconPlus\Bootstrap(dirname(dirname(__DIR__)));
    $di = new \Phalcon\DI\FactoryDefault\CLI();
    $di->set("dispatcher", function() {
        $disptcher = new \Phalcon\CLI\Dispatcher();
        return $disptcher;
    });
    $di->set("dispatched", function() {
        return true;
    });
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(__DIR__))
           ->register();
    $argv = $GLOBALS["argv"];
    array_shift($argv); // 去掉脚本文件名
    $uri = array_shift($argv);
    $uriPieces = explode(":", $uri);
    $arguments = [];
    foreach ($uriPieces as $k => $arg) {
        if($k == 0) {
            $arguments['task'] = \Phalcon\Text::camelize($arg)."Task";
        } elseif($k == 1) {
            $arguments['action'] = "mainAction";
        } elseif($k = 2) {
            $arguments['params'] = explode(",", $arg);
        }
    }
    if(empty($arguments['action'])) {
        $arguments['action'] = "mainAction";
    }
    $bootstrap->execTask([], $di, false);
    return call_user_func_array([$arguments['task'],
                                 $arguments["action"]],
                                [$arguments["params"]]);
}

$workers = [];
$workerNum = 8;

for($i = 0; $i < $workerNum; $i++) {
    $process = new swoole_process('child_sync');
    $pid = $process->start();
    $workers[$pid] = $process;
}

master_sync($workers);

// 同步主进程
function master_sync($workers)
{
    $taskList = generate();
    $taskCount = count($taskList); // 任务数量
    $childrenCount = count($workers); // 子进程数量
    $size = intval(ceil($taskCount/$childrenCount)); // 每个任务大小
    $chunks = array_chunk($taskList, $size, true);
    $chunks = array_pad($chunks, $childrenCount, []);
    $i = 0;
    foreach($workers as $pid => $process) {
        $process->write(json_encode($chunks[$i++]));
        echo "From Worker: ". $process->read();
    }
}

function child_sync(swoole_process $worker)
{
    $pid = $worker->pid;
    echo "Worker: start. PID=".$pid."\n";
    // recv data from master
    $recv = $worker->read();
    invoke($recv);
    // send data to master
    $worker->write("Worker ".$pid." complete\n");
    sleep(2);
    $worker->exit(0);
}
