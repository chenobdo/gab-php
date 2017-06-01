<?php
/***********************************
 *             Gab PHP             *
 *                                 *
 * A light php framework for study *
 *                                 *
 *             Gabriel             *
 *  <https://github.com/obdobriel> *
 *                                 *
 ***********************************/

namespace Framework\Orm;

use Framework\Exceptions\CoreHttpException;

/**
 * Sql 解释器
 */
class Interpreter
{
	/**
    * 表名
    * @var string
    */
    private $tableName = '';

    /**
    * 当前类的实例
    * @var object
    */
    private static $instance;

    public static function db($tableName = '')
    {
    	if (empty($tableName)) {
    		throw new CoreHttpException("argument tableName is null", 400);
    	}
    	// 单例
    	if (!self::$instance instanceof self) {
    		self::$instance = new self();
    	}
    	// 更新实例表名
        self::$instance->setTableName($tableName);
        // 返回实例
        return self::$instance;
    }

    private function setTableName($tableName)
    {
    	$this->tableName = $tableName;
    }

    /**
     * 增加数据
     * @param  array  $data 数据
     * @return mixed
     */
    public function insert($data = [])
    {
    	if (empty($data)) {
    		throw new CoreHttpException("argument data is null", 400);
    	}
    	$count = count($data);
    	// 拼接字段
		$field = array_keys($data);
		$fieldString = '';
		foreach ($field as $k => $v) {
			if ($k === intval($count - 1)) {
				$fieldString .= "`{$v}`";
				continue;
			}
			$fieldString .= "`{$v}`".",";
		}
		unset($k);
    	unset($v);

    	//拼接值
    	$value = array_values($data);
    	$value = array_keys($data);
		$valueString = '';
		foreach ($value as $k => $v) {
			if ($k === intval($count - 1)) {
				$valueString .= "`{$v}`";
				continue;
			}
			$valueString .= "`{$v}`".",";
		}
		unset($k);
    	unset($v);

    	$sql = "INSERT INTO `{$this->_tableName}` ({$fieldString}) VALUES ({$valueString})";
    	echo $sql . "\n";
    }

    public function delete($data = [])
    {
    	if (empty($data)) {
    		throw new CoreHttpException("argument data is null", 400);
    	}

    	//拼接where语句
    	$count = count($data);
    	$where = '';
    	$dataCopy = $data;
    	$pop = array_pop($dataCopy);
    	if ($count === 1) {
			$field = array_keys($data)[0];
			$value = array_values($data)[0];
			$where = "`{$field}` = '{$value}'";
    	} else {
    		foreach ($data as $k => $v) {
    			if ($v === $pop) {
    				$where .= "`{$k}` = '{$v}'";
    				continue;
    			}
    			$where .= "`{$k}` = '{$v}' AND ";
    		}
    	}

    	$sql = "DELETE FROM `{$this->tableName}` WHERE {$where}";
    	echo $sql . "\n";
    }

    /**
    *  更新一条数据
    *
    * @param  array $data 数据
    * @return mixed
    */
    public function update($data=[])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }
        if (empty($data['id'])) {
            throw new CoreHttpException("argument data['id'] is null", 400);
        }
        $set = '';
        $dataCopy = $data;
        $pop = array_pop($dataCopy);
        foreach ($data as $k => $v) {
            if ($v === $pop) {
                $set .= "`{$k}` = '$v'";
                continue;
            }
            $set .= "`{$k}` = '$v',";
        }

        $sql = "UPDATE `{$this->_tableName}` SET {$set}";

        echo $sql . "\n";
    }

    /**
    *  查找一条数据
    *
    * @param  array $data 数据
    * @return mixed
    */
    public function find($data=[])
    {
        if (empty($data)) {
            throw new CoreHttpException("argument data is null", 400);
        }

        // 拼接where语句
        $count = (int)count($data);
        $where = '';
        $dataCopy = $data;
        $pop = array_pop($dataCopy);
        if ($count === 1) {
            $field = array_keys($data)[0];
            $value = array_values($data)[0];
            $where = "`{$field}` = '{$value}'";
        }else{
            foreach ($data as $k => $v) {
                if ($v === $pop) {
                    $where .= "`{$k}` = '{$v}'";
                    continue;
                }
                $where .= "`{$k}` = '{$v}' AND ";
            }
        }

        $sql = "SELECT * FROM `{$this->_tableName}` WHERE {$where}";

        echo $sql . "\n";
    }
}
