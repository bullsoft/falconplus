<?php
namespace Command;

use Mage\Command\AbstractCommand;
use Mage\Command\RequiresEnvironment;
use Mage\Task\AbstractTask;
use Mage\Task\Factory;
use Mage\Console;

class PhpEnv extends AbstractCommand implements RequiresEnvironment
{
    public function run()
    {
        Console::output('PHP Environment Variables...', 1, 2);
        $tasks = $this->getConfig()->getTasks(AbstractTask::STAGE_POST_RELEASE);
        $hosts = $this->getConfig()->getHosts();
        foreach($hosts as $hostKey => $host) {
            $this->getConfig()->setHost($host);
            foreach($tasks as $taskData) {
                $task = Factory::get($taskData, $this->getConfig(), false, AbstractTask::STAGE_POST_RELEASE);
                if($task->getName() == "Task\\PhpEnv") {
                    $result = $task->run();
                    if($result == true) {
                        Console::output("<green>done.</green>");
                    }
                }
            }
        }
        return 0;
    }
}