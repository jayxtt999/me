<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-12-2
 * Time: 下午8:16
 */
class pdoMysql
{
    protected  $pdo = null;
    protected  $res = null;
    protected  $sql = null;
    function __construct($config)
    {
        try {
            $this->pdo = new PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            die ("Connect Error Infomation:" . $e->getMessage());
        }
    }

    public function query($sql){
        $res = $this->pdo->query($sql);
        if($res){
            $this->res = $res;
        }
    }

    public function exec($sql){
        $res = $this->pdo->exec($sql);
        if($res){
            $this->res = $res;
        }
    }
    public function fetchAll(){
        return $this->res->fetchAll();
    }
    public function fetch(){
        return $this->res->fetch();
    }
    public function fetchColumn(){
        return $this->res->fetchColumn();
    }
    public function lastInsertId(){
        return $this->res->lastInsertId();
    }

    public function getSql(){
        return $this->res->sql;
    }

    public function select($model=2,$table,$where="",$fields="*", $order="id desc",$limit=""){
        if(is_array($table)){
            $table = implode(', ', $table);
        }
        if(is_array($fields)){
            $fields = implode(', ', $fields);
        }
        if(is_array($where)){
            $where = ' and '.implode(' and ', $where);
        }
        $this->sql = "select $fields from $table where 1=1 $where order by $order";
        if($limit){
            $this->sql.=" limit $limit";
        }
        $this->query($this->sql);
        if($model==1){
            $this->res = $this->fetch();
        }else if($model==2){
            $this->res = $this->fetchAll();
        }
        return $this->res;
    }





}