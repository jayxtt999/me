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
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //Display exception
            $this->prefix = $config['prefix'];
        } catch (\PDOException $e) {
            $this->error();
        }
    }


    /**
     * @param $func
     * @param $args
     * @return mixed
     */
    public function __call($func, $args)
    {
        return call_user_func_array(array(&$this->pdo, $func), $args);
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
        if (false === $res) {
            $this->error();
        } else {
            $this->res = $res;
        }
        return $this->res;
    }

    /**
     * exec sql
     * @param $sql
     */
    public function exec($sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $exeres = $stmt->execute();
        if ($exeres) {
            $this->res = $exeres;
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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


    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
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
    public function error()
    {
        $this->error = $this->pdo->errorCode();
        if ('' != $this->sql) {
            $this->error .= "\n [ SQL语句 ] : " . $this->sql;
        }
        \System\Core\Error::trace($this->error, '', 'ERR');
        return $this->error;
    }

    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str SQL字符串
     * @return string
     */
    public function escapeString($str)
    {
        return addslashes($str);
    }



    /**
     * 数据库调试 记录当前SQL
     * @access protected
     * @param boolean $start  调试开始标记 true 开始 false 结束
     */
    protected function debug($start) {
        if(C('db:db_sql_log')) {// 开启数据库调试模式
            if($start) {
                G('queryStartTime');
            }else{
                //$this->model  =   '_think_';
                // 记录操作结束时间
                G('queryEndTime');
                \System\Core\Error::trace($this->sql.'[ RunTime:'.G('queryStartTime','queryEndTime').'s ]','','SQL');
            }
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
    public function select($model = 2, $table, $where = "", $fields = "*", $order = "", $limit = "", $count = false)
    {
        if (is_array($table)) {
            $table = implode(', ', $table);
        }
        if (is_array($fields)) {
            $fields = implode(', ', $fields);
        }
        //$whereDataCache 用于缓存
        $whereData = $whereDataCache = "";
        $whereVal = array();
        // 循环$where
        if ($where) {
            if (is_array($where)) {
                foreach ($where as $key => $val) {
                    if (is_array($val)) {
                        $whereVal["w_" . $key] = "(" . implode(",", $val) . ")";
                        $whereData .= " and " . "`" . $key . "` in (:w_$key)";
                        $whereDataCache .= " and " . "`" . $key . "` in  (" . implode(",", $val) . ")";
                        continue;
                    }
                    $wz = strpos($key, "?");
                    $parame = $wz ? substr($key, $wz + 1) : "=";
                    if ($wz) {
                        $key = substr($key, 0, $wz);
                    }
                    $whereVal["w_" . $key] = $val;
                    $whereData .= " and " . "`" . $key . "` " . $parame . "(:w_$key)";
                    $whereDataCache .= " and " . "`" . $key . "` " . $parame . "\"$val\"";
                }
            } else {
                exception("$where not is array()");
            }
        }
        //Sql
        $this->sql = "select $fields from " . $this->prefix . "$table where 1=1 $whereData ";
        $sqlCache = "select $fields from " . $this->prefix . "$table where 1=1 $whereDataCache ";
        //处理不支持预处理的 order by limit
        if ($order || $limit) {
            $order = $order ? $order : "id desc";
            $limit = $limit ? "LIMIT " . $limit : "";
            $this->sql = "select $fields from " . $this->prefix . "$table where 1=1 $whereDataCache order by $order $limit";
            $sqlCache = "select $fields from " . $this->prefix . "$table where 1=1 $whereDataCache order by $order $limit";
        }

        $type = C("cache:type") ? C("cache:type") : false;
        $type = false;
        //如果存在缓存
        if ($type) {
            if (cache("sql_" . $sqlCache)) {
                return cache("sql_" . $sqlCache);
            }
        }
        try {
            $this->debug(true);
            $stmt = $this->pdo->prepare($this->sql);
            if ($order || $limit) {
                $exeres = $stmt->execute();
            } else {
                $exeres = $stmt->execute($whereVal);
            }
            //根据查询条件取出结果集
            if ($model == 1) {
                $this->res = $stmt->fetch(\PDO::FETCH_ASSOC);
            } else if ($model == 2) {
                if ($count) {
                    $this->res = $stmt->rowCount();
                } else {
                    $this->res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                }
            }
            $this->debug(false);

            /*
            //如果存在 只取fields 多条 返回array 单条 返回值
             if (($fields !== "*")) {
                 if ($model == 2) {
                     foreach ($this->res as $v) {
                         $_res[] = $v[$fields];
                     }
                     $this->res = $_res;
                 } else {
                     $this->res = $this->res[$fields];
                 }
             }*/
            //缓存sql结果
            if ($type) {
                cache("sql_" . $sqlCache, $this->res);
            }
            return $this->res;
        } catch (\Exception $ex) {
            exception($ex->getMessage());
        }


    }


    /**
     * 更新记录
     * @param $table
     * @param array $data
     * @param array $where
     * @return int
     */
    public function update($table, array $data, array $where)
    {
        if (is_array($data) && is_array($where)) {
            $setSql = $whereSql = "";
            $len = count($data);
            $i = 0;
            $dataVal = array();
            foreach ($data as $k => $v) {
                $i++;
                $semicolon = $len == $i ? " " : ",";
                $dataVal["d_" . $k] = $v;
                if (strpos($v, "+") || strpos($v, "-")) {
                    $buildModel = true;
                } else {
                    $buildModel = false;
                }
                $setSql .= "`" . $k . "`" . "=(" . ":d_$k" . ")" . $semicolon;
            }
            $this->sql = "UPDATE " . $this->prefix . $table . " SET " . $setSql . " WHERE 1=1";
            foreach ($where as $k => $v) {
                $dataVal["w_" . $k] = $v;
                $whereSql .= " AND " . "`" . $k . "`" . "=(" . ":w_$k" . ")";
            }
            $this->sql .= $whereSql;
            try {
                if ($buildModel) {
                    $buildSql = $this->update_pdo_query($this->sql, $dataVal);
                    return $this->pdo->exec($buildSql);
                } else {
                    $stmt = $this->pdo->prepare($this->sql);
                    $stmt->execute($dataVal);
                    return $stmt->rowCount();

                }
            } catch (\Exception $ex) {
                exception($ex->getMessage());
            }

        } else {
            exception("ERROR:update 必须传入参数");
        }
    }

    /**
     * 插入记录
     * @param $table
     * @param array $data
     * @return string
     */
    public function insert($table, array $data)
    {
        if (is_array($data)) {
            $column = $value = "";
            $len = count($data);
            $i = 0;
            $dataVal = array();
            foreach ($data as $k => $v) {
                $i++;
                $semicolon = $len == $i ? " " : ",";
                $column .= "`" . $k . "`" . $semicolon;
                $value .= "(:$k)" . $semicolon;
                $dataVal[$k] = $v;
                //INSERT INTO table_name (列1, 列2,...) VALUES (值1, 值2,....)
            }
            $this->sql = "INSERT " . $this->prefix . $table . "(" . $column . ") VALUES (" . $value . ")";
            try {
                $stmt = $this->pdo->prepare($this->sql);
                $stmt->execute($dataVal);
                return $this->pdo->lastInsertId();
            } catch (\Exception $ex) {
                exception($ex->getMessage());
            }

        } else {
            exception("ERROR:insert 必须传入参数");
        }
    }

    /**
     * 删除记录
     * * @param $table
     * @param array $where
     * @return int
     */
    public function delete($table, array $where)
    {
        if (is_array($where)) {
            $whereData = "";
            $whereVal = array();
            foreach ($where as $key => $val) {
                $whereVal[$key] = $val;
                $wz = strpos($key, "?");
                $parame = $wz ? substr($key, $wz + 1) : "=";
                $k = substr($key, 0, $wz);
                $whereData .= " and " . "`" . $key . "`" . $parame . "(:$key)";
            }
            $this->sql = "DELETE FROM " . $this->prefix . $table . " WHERE 1=1 " . $whereData;
            try {
                $stmt = $this->pdo->prepare($this->sql);
                $stmt->execute($whereVal);
                return $stmt->rowCount();
            } catch (\Exception $ex) {
                exception($ex->getMessage());
            }

        } else {
            exception("ERROR:delete必须传入参数");
        }


    }

    /**
     *  获取新行
     * @param $table
     * @return string
     */
    public function getnewrow($table)
    {

        $data = array();
        return $this->insert($table, $data);

    }

    /**
     * prepare转sql 用于有些无法使用pdo prepare过滤方式 ==> update table set a=a+1
     * @param $string
     * @param $array
     * @return mixed
     */
    function update_pdo_query($string, $array)
    {
        //Get the key lengths for each of the array elements.
        $keys = array_map('strlen', array_keys($array));

        //Sort the array by string length so the longest strings are replaced first.
        array_multisort($keys, SORT_DESC, $array);

        foreach ($array as $k => $v) {
            //Quote non-numeric values.
            if (substr($k, 0, 2) == "d_") {
                $replacement = is_numeric($v) ? $v : $v;
            } else {
                $replacement = is_numeric($v) ? $v : "'{$v}'";
            }
            //Replace the needle.
            $string = str_replace("(:" . $k . ")", $replacement, $string);
        }

        return $string;
    }


}