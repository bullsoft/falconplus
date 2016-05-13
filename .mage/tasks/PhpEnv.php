<?php
namespace Task;

use Mage\Task\AbstractTask;
use Mage\Console;

class PhpEnv extends AbstractTask
{
    public function getName()
    {
        return __CLASS__;
    }

    public function run()
    {
        $excludes = $this->getParameter('excludes', []);
        $host = $this->getConfig()->getHost();
        Console::output("Process host: <red>" . $host . "</red>");
        if(in_array($host, $excludes, true)) {
            Console::output("<yellow>Ignore PhpEnv task in host: " . $host . "</yellow>");
            return true;
        }
        $args = $this->getConfig()->getArguments();
        array_shift($args);
        if(empty($args)) {
            Console::output("<red>未指定指令</red>");
            return false;
        }
        $subCommand = array_shift($args);
        $content = "";
        switch($subCommand) {
        case "list":
            $command = '. ~/.profile && env | grep "PHP_"';
            $result = $this->runCommandRemote($command, $content);
            Console::output("<red>[ENV]</red>\n".$content);
            break;
        case "sync":
            foreach($args as $arg) {
                $k = strstr($arg, '=', true);
                $v = strstr($arg, '=');
                $var = "export {$k}";
                Console::output("\tSync env {$k}{$v}");
                $command = "if grep -q '{$var}' ~/.profile; then sed -i 's/^{$var}=.*/{$var}{$v}/g' ~/.profile; else ";
                $command .= sprintf('echo \'%s\' >> ~/.profile; fi', "export ". $arg);
                $result = $this->runCommandRemote($command, $content);
                if(!$result) {
                    Console::output("\tSync {$k} <red>failed</rd>");
                    break;
                }
            }
            break;
        default:
            Console::output("<red>指令不存在</red>");
            return false;
        }
        return $result;
    }
}