<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/26
 * Time: 17:40
 */

namespace Demo\Server\Daos;
use PhalconPlus\Assert\Assertion as Assert;

class ProductDao
{
    public static function getByCateId($cateId, $pageNo = 1, $pageSize = 10)
    {
        $cateId = intval($cateId);
        Assert::numeric($pageNo);
        Assert::numeric($pageSize);
        $from = ($pageNo - 1) * $pageSize;

        // 变态!!!这么大的SQL, 并发大的话要么静态化列表页要么缓存进redis
        $sql = 'SELECT si.id, si.name, si.cate_id AS cateId, si.product_id AS productId, '.
                      'si.slogan, si.price, si.amount, si.discount_id, si.sell_type AS sellType, si.btime, si.etime, ' .
                      'group_concat(concat_ws("||", sf.field_id, sf.field_name, sf.field_value, '.
                                                   'sf.display_name, sf.is_required) SEPARATOR '. "'@@') " .
                      'AS extends '.
               'FROM sku_info AS si, '.
                     '(SELECT sfi.sku_id, sfi.product_id, sfi.cate_id, sfi.field_id, sfi.field_value, '.
                             'cf.field_name, cf.display_name, cf.`is_required`, cf.`is_show` '.
                      'FROM sku_field_info AS sfi LEFT JOIN category_field AS cf ON (sfi.`field_id`=cf.`id`)) AS sf '.
               'WHERE si.id = sf.sku_id AND si.is_delete = 0 AND si.cate_id = :cateId GROUP BY si.id'; 

        $sql .= " LIMIT {$from}, {$pageSize}"; // 分页处理
        $db = getDI()->get("dbDemo");
        $rows = $db->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, ["cateId" => $cateId]);
        return $rows;
    }

}