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
    protected $options = '';
    protected $where = null;
    protected $selectmodel;
    protected $data;
    public function init($config)
    {
        $this->db = new \System\Library\Db\pdoMysql($config['pdoMysql']);
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function getRow($where = null)
    {

        $this->options = "SELECT";
        $this->selectmodel = 1;
        $this->where = $where;
        $this->limit = 1;
        return $this;
    }

    public function getAll($where = null)
    {
        $this->options = "SELECT";
        $this->selectmodel = 2;
        $this->where = $where;
        $this->limit = "";
        return $this;
    }

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function fields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function done()
    {
        switch ($this->options) {
            case "SELECT":
                return $this->db->select($this->selectmodel, $this->table, $this->where, $this->fields, $this->order, $this->limit);
                break;
            case "UPDATE":
                return $this->db->upDate($this->table,$this->data, $this->where);
                break;
        }
    }

    public function getSql()
    {
        return $this->res->getSql();
    }

    /**
     * @access public
     */
    public function __destruct() {

    }

    public function upDate(array $data,array $where){
        $this->options = "UPDATE";
        $this->data = $data;
        $this->where = $where;
        return $this;
    }


}

