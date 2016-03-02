<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/2/25
 * Time: 18:22
 */

namespace BullSoft;

class Category
{
    /**
     * 表名
     *
     * @access private
     * @var string
     */
    private $_table = 'category';

    /**
     * 数据库对象
     *
     * @access private
     * @var object
     */
    private $_db;

    /**
     * 构造器
     *
     * @access public
     */
    public function __construct($db)
    {
        $this->_db = $db;
    }

    /**
     * 增加节点
     *
     * @access public
     * @param string $cname
     * @param integer $pid
     * @return mixed
     */
    public function add($cname, $pid = 1)
    {
        //检查同级分类中是否有同名节点
        $has = $this->hasChildrenByName($pid, $cname);
        if (!$has && $parent = $this->getOne($pid)) {
            try {
                $this->_db->begin();
                //将所有后添加的结点的左值扩展2
                $sql = "UPDATE {$this->_table} SET lft=lft+2 WHERE lft>". intval($parent['rgt']);
                $this->_db->execute($sql);
                //把父分类的所有父级及后添加的结点右边界值扩展2
                $sql = "UPDATE {$this->_table} SET rgt=rgt+2 WHERE rgt>=". intval($parent['rgt']);
                $this->_db->execute($sql);
                //新加入节点，本节点的左值为父节点的原右值，右值为左值+1
                $sql = "INSERT INTO {$this->_table}(pid, depth, lft, rgt, name) VALUES('{$pid}', '". (intval($parent['depth'])+1). "', '". intval($parent['rgt']). "', '". (intval($parent['rgt'])+1). "', '". $cname. "')";
                $this->_db->execute($sql);
                $cid = $this->_db->lastInsertId();
                return $this->_db->commit() ? $cid : false;
            } catch (\Exception $e) {
                $this->_db->rollback();
                return false;
            }
        }
        return $has;
    }

    /**
     * 取单个分类节点数据
     *
     * @access public
     * @param integer $id
     * @return array
     */
    public function getOne($id)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE id={$id}";
        return $this->_db->fetchOne($sql);
    }

    /**
     * 删除节点
     *
     * @access public
     * @param int $id
     * @param array $node
     * @return bool
     */
    public function del($id, $node = array())
    {
        $node || $node = $this->getOne($id);
        if ($node) {
            try {
                $this->_db->begin();
                //删除当前要删除节点及其子节点
                $sql = "delete from {$this->_table} where lft>=". intval($node['lft']). " and rgt<=". intval($node['rgt']);
                $this->_db->execute($sql);
                //重置被删除节点父节点的左右值
                $offset = $node['rgt'] - $node['lft'] + 1;
                //重新校正所有左边界值大于被删除节点右边界值的节点(一般指创建在被删除节点之后的那些节点)
                $sql = "update {$this->_table} set lft=lft-{$offset} where lft>". intval($node['rgt']);
                $this->_db->execute($sql);
                //同上，校正被删除节点父级分类及后来创建分类的右边界值
                $sql = "update {$this->_table} set rgt=rgt-{$offset} where rgt>". intval($node['rgt']);
                $this->_db->execute($sql);
                return $this->_db->commit();
            } catch (\Exception $e) {
                $this->_db->rollback();
                return false;
            }
        }
        return false;
    }


    /**
     * 根据某结点数据取得其子结点数
     *
     * @access public
     * @param int $id
     * @return integer
     */
    public function getChildrenNum($id)
    {
        $num = 0;
        $node = $this->getOne($id);
        if ($node['depth'] > 0) {
            $num = max(($node['rgt'] - $node['lft'] - 1)/2, 0);
        }
        return $num;
    }

    /**
     * 获取最大节点深度
     *
     * @access public
     * @return int
     */
    public function getMaxDepth()
    {
        $sql = "select depth from {$this->_table} order by depth desc limit 1";
        return (int)$this->_db->fetchOne($sql);
    }

    /**
     * 根据ID获取相应的分类项
     *
     * @access public
     * @param array $ids
     * @return array
     */
    public function get($ids)
    {
        is_array($ids) || $ids = array($ids);
        $sql = "select * from {$this->_table} where id in (". implode(',', $ids). ") order by id asc";
        return $this->_db->fetchAll($sql);
    }

    /**
     * 取得节点的子节点
     *
     * @param integer $id 节点ID
     * @param integer $depth 获取的子节点深度
     * @param boolean $backward 返回的数据是否包含本身
     * @return array
     */
    public function getChildren($id, $depth, $backward = false)
    {
        $node = $this->getOne($id);
        $sql = "select * from {$this->_table} where lft>";
        $sql.= ($backward ? '=' : ''). intval($node['lft']);
        $sql.= ' and rgt<'. ($backward ? '=' : ''). intval($node['rgt']);
        $sql.= ' and depth'. ($backward ? '<' : ''). '='. (intval($node['depth']) + $depth);
        $sql.= ' order by lft asc';
        return $this->_db->fetchAll($sql);
    }

    /**
     * 获取顶层结点
     *
     * @access public
     * @return array
     */
    public function getTops()
    {
        $sql = "select * from {$this->_table} where depth = 1 order by lft asc";
        return $this->_db->fetchAll($sql);
    }

    /**
     * 取得节点的父节点
     *
     * @access public
     * @param integer $id
     * @return array
     */
    public function getParents($id)
    {
        $node = $this->getOne($id);
        $sql = "SELECT * FROM {$this->_table} WHERE lft < ". intval($node['lft']). " AND rgt > ". intval($node['rgt']). " AND depth > 0 ORDER BY lft ASC";
        return $this->_db->fetchAll($sql);
    }

    /**
     * 取得节点上一个父节点
     *
     * @access public
     * @param integer $id
     * @return array
     */
    public function getParent($id)
    {
        $node = $this->getOne($id);
        $sql = "SELECT * FROM {$this->_table} WHERE lft < ". intval($node['lft']). " AND rgt > ". intval($node['rgt']). " ORDER BY lft DESC limit 1";
        return $this->_db->fetch($sql);
    }

    /**
     * 节点是否存在
     *
     * @param integer $id
     * @return int
     */
    public function has($id)
    {
        $sql = "SELECT COUNT(*) FROM {$this->_table} WHERE id = ". intval($id);
        return (bool)$this->_db->fetchOne($sql);
    }

    /**
     * 查询某结点是否存在子结点
     *
     * @access public
     * @param integer $id
     * @return integer
     */
    public function hasChildren($id)
    {
        $sql = "SELECT COUNT(*) FROM {$this->_table} WHERE pid = ". intval($id);
        return (int)$this->_db->fetchOne($sql);
    }

    /**
     * 判断某节点下是否存在某名称的子节点
     *
     * @access public
     * @param integer  $cid
     * @param string $cname
     * @return integer
     */
    public function hasChildrenByName($cid, $cname)
    {
        $sql = "SELECT id FROM {$this->_table} WHERE name = '{$cname}' AND pid = {$cid}";
        return $this->_db->fetchOne($sql);
    }

    /**
     * 更新节点的值
     *
     * @access public
     * @param array $bind
     * @param array $where
     * @return bool
     */
    public function update($id, array $bind)
    {
        $sql = "UPDATE {$this->_table} SET ";
        foreach ($bind as $k=> $v) {
            $sql .= "{$k} = ". (is_string($v) ? "'{$v}'" : intval($v)). ", ";
        }
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE id = ". intval($id);
        return is_integer($this->_db->execute($sql));
    }

}