<?php

class DB
{

    protected $db;
    protected $res;                //�����
    protected $table;              //���ñ�
    protected $order = "id desc";  //ordere
    protected $fields = "*";       // fields
    protected $limit;              //limit
    protected $options;            //ѡ�� SELECT INSERT UPDATE DELETE
    protected $where;              // where ��� string || array
    protected $selectmodel;        //1 ����һ�� 2 ����ȫ��

    public function init($config)
    {
        require_once SYS_LIB_PATH . '/DB/pdomysql.class.php';
        $this->db = new pdoMysql($config['pdoMysql']);
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
        }
    }

    public function getSql()
    {
        return $this->res->getSql();
    }


}

