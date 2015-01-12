<?php
namespace System\Library\Db;
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
    protected $error = null;
    protected $prefix = null;
    /**
     * 初始化
     * @param $config
     */
    function __construct($config)
    {
        try {
            $this->pdo = new \PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            $this->prefix = $config['prefix'];
        } catch (\PDOException $e) {
            $this->error();
        }
    }

    /**
     * query sql
     * @param $sql
     */
    public function query($sql)
    {
        G('queryStartTime');
        $res = $this->pdo->query($sql);
        $this->debug();
        if ( false === $res ) {
            $this->error();
        } else{
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


    public function beginTransaction(){
        $this->pdo->beginTransaction();
    }

    public function commit(){
        $this->pdo->commit();
    }

    public function rollBack(){
        $this->pdo->rollBack();
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
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    public function error() {
        $this->error = $this->pdo->errorCode();
        if('' != $this->sql){
            $this->error .= "\n [ SQL语句 ] : ".$this->sql;
        }
        trace($this->error,'','ERR');
        return $this->error;
    }

    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str  SQL字符串
     * @return string
     */
    public function escapeString($str) {
        return addslashes($str);
    }


    /**
     * 数据库调试 记录当前SQL
     * @access protected
     */
    protected function debug() {
        // 记录操作结束时间
        if (C('db:db_sql_log')) {
            G('queryEndTime');
            \System\Core\Error::trace($this->sql.' [ RunTime:'.G('queryStartTime','queryEndTime',6).'s ]','','SQL');
        }
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
        $whereData = "";
        $whereVal = array();
        if($where){
            if (is_array($where)) {
                foreach ($where as $key => $val) {
                    $whereVal[] = $val;
                    $wz = strpos($key, "?");
                    $parame = $wz ? substr($key, $wz + 1) : "=";
                    $k = substr($key, 0, $wz);
                    $whereData .= " and " . "`".$key."`" . $parame . "?";
                }
            } else {
               exception("$where not is array()");
            }
        }
        $whereVal[]=$order;
        $this->sql = "select $fields from ".$this->prefix."$table where 1=1 $whereData order by ?";
        if ($limit) {
            $this->sql .= " limit ?";
            $whereVal[]=$limit;
        }
        $stmt = $this->pdo->prepare($this->sql);
        $exeres = $stmt->execute($whereVal);
        if ($model == 1) {
            $this->res = $stmt->fetch(\PDO::FETCH_ASSOC);
        } else if ($model == 2) {
            $this->res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $this->res;
    }


    public function upDate($table,array $data,array $where){
        if(is_array($data) && is_array($where)){
            $setSql = $whereSql = "";
            $len = count($data);
            $i = 0;
            foreach($data as $k=>$v){
                $i++;
                $semicolon = $len == $i?" ":",";
                $setSql .= "`".$k."`"."=\"".$v."\"".$semicolon;
            }
            $this->sql = "UPDATE ".$this->prefix.$table." SET ". $setSql." WHERE 1=1";
            foreach($where as $k=>$v){
              $whereSql .= " AND "."`".$k."`"."=\"".$v."\"";
            }
            $this->sql.=$whereSql;
            $stmt = $this->pdo->prepare($this->sql);
            return  $stmt->rowCount();
        }else{
            exception("Data update parameter error..");
        }

    }


}