<?php
namespace Demo\Server\Models;

class DealRecord extends \PhalconPlus\Base\Model
{
    public function onConstruct()
    {
    }
    
    public function initialize()
    {
        parent::initialize();
        $this->setConnectionService('dbDemo');
    }

    public function columnMap()
    {
        return array(
            "id"          => "id",
            "deal_id"     => "dealId",
            "investor_id" => "investorId",
            "borrower_id" => "borrowerId",
            "amount"      => "amount",
            "ctime"       => "ctime",
            "mtime"       => "mtime",
        );
    }

    public function getSource()
    {
        return "deal_record";
    }

}
