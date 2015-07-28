<?php
namespace System\Core;
class DB
{

    protected $db;
    protected $res;
    protected $table = '';
    protected $order = "id desc";
    protected $fields = "*";
    protected $limit = '';
    protected $count = false;
    protected $options = '';
    protected $where = null;
    protected $selectmodel;
    protected $data;
    protected $build =false;

    /**
     * @param $property_name
     * @return null
     */
    public function __get($property_name)
    {
        if (isset($this->$property_name)) {
            return ($this->$property_name);
        } else {
            return NULL;
        }
    }

    /**
     * @param $property_name
     * @param $value
     */
    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }

    /**
     * 初始化配置
     * @param $config
     */
    public  function init($config)
    {
        $this->db = new \System\Library\Db\PdoMysql($config[$config['db_type']]);
    }

    /**
     * 设置表
     * @param $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * 获取一行记录
     * @param null $where
     * @return $this
     */
    public function getRow($where = null)
    {
        $this->options = "SELECT";
        $this->selectmodel = 1;
        $this->where = $where;
        $this->order = "";
        $this->limit = "";
        $this->count = false;
        return $this;
    }




    public function getNewRow()
    {

        $this->options = "GETNEWROW";
        return $this;
    }

    public function getTableStructure()
    {
        $this->options = "GETTABLESTRUCTURE";
        return $this;
    }


    /**
     *获取全部记录
     * @param null $where
     * @return $this
     */
    public function getAll($where = null)
    {
        $this->options = "SELECT";
        $this->selectmodel = 2;
        $this->where = $where;
        $this->order = "";
        $this->limit = "";
        $this->fields = "*";
        $this->count = false;
        return $this;
    }


    /**
     * 统计
     * @return $this
     */
    public function count()
    {

        $this->count = true;
        return $this;

    }


    /**
     * 定义排序方式
     * @param $order
     * @return $this
     */
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * 定义字段
     * @param $fields
     * @return $this
     */
    public function fields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * 定义限制
     * @param $limit
     * @return $this
     */
    public function limit($start,$length)
    {
        $this->limit = "$start,$length";
        return $this;
    }


    /**
     * 直接sql
     * @param $sql
     * @return mixed
     */
    public function sql($sql){

        return $this->db->exec($sql);

    }


    /**
     * Done
     * @return mixed
     */
    public function done()
    {
        switch ($this->options) {
            case "SELECT":
                return $this->db->select($this->selectmodel, $this->table, $this->where, $this->fields, $this->order, $this->limit, $this->count);
                break;
            case "UPDATE":
                return $this->db->update($this->table, $this->data, $this->where,$this->build);
                break;
            case "INSERT":
                return $this->db->insert($this->table, $this->data);
                break;
            case "DELETE":
                return $this->db->delete($this->table, $this->where);
                break;
            case "GETNEWROW":
                return $this->db->getnewrow($this->table);
                break;
            case "GETTABLESTRUCTURE":
                return $this->db->getTableStructure($this->table);
                break;
        }
    }





    /**
     * 获取sql
     * @return mixed
     */
    public function getSql()
    {
        return $this->res->getSql();
    }

    /**
     * 更新
     * @param array $data
     * @param array $where
     * @return $this
     */
    public function upDate(array $data, array $where)
    {
        $this->options = "UPDATE";
        $this->data = $data;
        $this->where = $where;
        return $this;
    }

    public function build(){
        $this->build = true;
        return $this;
    }

    /**
     * 插入
     * @param array $data
     * @return $this
     */
    public function insert(array $data)
    {
        $this->options = "INSERT";
        $this->data = $data;
        return $this;
    }

    /**
     * 删除
     * @param array $where
     * @return $this
     */
    public function delete(array $where)
    {
        $this->options = "DELETE";
        $this->where = $where;
        return $this;
    }

    /**
     * 事务开始
     * @return mixed
     */
    public function beginTransaction(){
        return $this->db->beginTransaction();
    }

    /**
     * 事务提交
     * @return mixed
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * 事务回滚
     * @return mixed
     */
    public function rollBack()
    {
        return $this->db->rollBack();
    }

    /**
     * @access public
     */
    public function __destruct()
    {

    }


}

