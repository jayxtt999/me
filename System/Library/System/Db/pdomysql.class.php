<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-2
 * Time: 下午8:16
 */
class pdoMysql
{
    protected $pdo = null;
    protected $res = null;
    protected $sql = null;

    /**
     * 初始化
     * @param $config
     */
    function __construct($config)
    {
        try {
            $this->pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            die ("Connect Error Infomation:" . $e->getMessage());
        }
    }

    /**
     * query sql
     * @param $sql
     */
    public function query($sql)
    {
        $res = $this->pdo->query($sql);
        if ($res) {
            $this->res = $res;
        }
    }

    /**
     * exec sql
     * @param $sql
     */
    public function exec($sql)
    {
        $res = $this->pdo->exec($sql);
        if ($res) {
            $this->res = $res;
        }
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        return $this->res->fetchAll();
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
        return $this->res->fetch();
    }

    /**
     * @return mixed
     */

    public function fetchColumn()
    {
        return $this->res->fetchColumn();
    }

    /**
     * @return mixed
     */

    public function lastInsertId()
    {
        return $this->res->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->res->sql;
    }

    /**
     * @param int $model 模式 1 返回单挑 2 多条
     * @param $table    表名
     * @param string $where where条件 string或array 条件段 使用 ? + "$p" 如 array('id?<>'=>1) 表示id 不为1
     * @param string $fields 字段
     * @param string $order 排序
     * @param string $limit 限制
     * @return null
     */
    public function select($model = 2, $table, $where = "", $fields = "*", $order = "id desc", $limit = "")
    {
        if (is_array($table)) {
            $table = implode(', ', $table);
        }
        if (is_array($fields)) {
            $fields = implode(', ', $fields);
        }

        if (is_array($where)) {

            $whereData = "";
            foreach ($where as $k => $v) {
                $wz = strpos($k, "?");
                $parame = $wz ? substr($k, $wz + 1) : "=";
                $k = substr($k, 0, $wz);
                $whereData .= " and " . $k . $parame . $v;
            }
            //$where = ' and '.implode(' and ', $where);
            //var_dump($whereData);exit;
        } else {
            $whereData = $where;
        }
        $this->sql = "select $fields from $table where 1=1 $whereData order by $order";
        if ($limit) {
            $this->sql .= " limit $limit";
        }
        $this->query($this->sql);
        if ($model == 1) {
            $this->res = $this->fetch();
        } else if ($model == 2) {
            $this->res = $this->fetchAll();
        }
        return $this->res;
    }


}