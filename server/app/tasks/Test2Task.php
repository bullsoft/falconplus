<?php
use Demo\Server\Models\UserPayinfo;

class Test2Task extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        throw new \Exception("dfadf");
        try {
            $tx = $this->di->get('tx', ["dbDemo"]);
            $m = UserPayinfo::findFirst(1);
            $m->setTransaction($tx);
            $m->paySpId = 11111;
            $m->save();
            var_dump(UserPayinfo::findFirst(1)->toArray());
            $tx->commit();

        }catch(\Exception $e) {
            var_dump($e);
        }
        var_dump(UserPayinfo::findFirst(1)->toArray());
    }
}
