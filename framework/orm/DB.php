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

use Framework\App;
use Framework\Exceptions\CoreHttpException;

/**
 * DB
 */
class DB
{
	/**
     * Sql解释器
     */
    use Interpreter;

    /**
     * 数据库类型
     *
     * 目前只支持mysql
     *
     * @var string
     */
    protected $dbtype  = '';

    /**
     * 表名称
     *
     * table name
     *
     * @var string
     */
    protected $tableName = '';

    /**
     * 数据库策略映射
     *
     * 目前只支持mysql
     *
     * @var array
     */
    protected $dbStrategyMap  = [
        'mysqldb' => 'Framework\Orm\Db\Mysql'
    ];

    /**
     * db instance
     *
     * @var object
     */
    protected $dbInstance;

    /**
     * 自增id
     *
     * 插入数据成功后的自增id, 0为插入失败
     *
     * @var string
     */
    protected $id = '';

    /**
    * 当前查询主从
    *
    * @var object
    */
    private $masterSlave = '';

     /**
     * 构造函数
     */
    public function __construct()
    {
        $this->init();
    }

    static public function table($tableName = '')
    {
    	$db = new self;
        $db->tableName = $tableName;
        $prefix = App::$container->getSingle('config')
                                 ->config['database']['dbprefix'];
        if (! empty($prefix)) {
            $db->tableName = $prefix . '_' . $db->tableName;
        }
        $db->init();

        return $db;
    }

    public function init()
    {
    	$config = App::$container->getSingle('config');
    	$this->dbtype = $config->config['database']['dbtype'];
    	$this->decide();
    }

    public function decide()
    {
    	$dbStrategyName = $this->dbStrategyMap[$this->dbtype];
    	$this->dbInstance = APP::$container->setSingle(
    		$this->dbtype,
    		function () use ($dbStrategyName) {
    			return new $dbStrategyName();
    		}
		);
    }

    /**
     * 查找一条数据
     * @param  array  $data 查询的字段
     * @return void
     */
    public function findOne($data = [])
    {
    	$this->select($data);
    	$this->buildSql();
    	$functionName = __FUNCTION__;
 		return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     * @param  array  $data 查询的字段
     * @return void
     */
    public function findAll($data = [])
    {
    	$this->select($data);
    	$this->buildSql();
    	$functionName = __FUNCTION__;
 		return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @return void
     */
    public function save($data = [])
    {
        $this->insert($data);
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @return void
     */
    public function delete()
    {
        $this->del();
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * 查找所有数据
     *
     * @param  array $data 数据
     * @return void
     */
    public function update($data = [])
    {
        $this->updateData($data);
        $this->buildSql();
        $functionName = __FUNCTION__;
        return $this->dbInstance->$functionName($this);
    }

    /**
     * count数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function count($data = '')
    {
        $this->countColumn($data);
        $this->buildSql();
        return $this->dbInstance->findAll($this);
    }

    /**
     * sum数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function sum($data = '')
    {
        $this->sumColumn($data);
        $this->buildSql();
        return $this->dbInstance->findAll($this);
    }

    /**
     * sum数据
     *
     * @param  string $data 数据
     * @return void
     */
    public function query($sql = '')
    {
        $this->querySql($sql);
        return $this->dbInstance->query($this);
    }



    public function buildSql()
    {
    	if (!empty($this->where)) {
    		$this->sql .= $this->where;
    	}
    	if (!empty($this->orderBy)) {
    		$this->sql .= $this->orderBy;
    	}
    	if (!empty($this->limit)) {
    		$this->sql .= $this->limit;
    	}
    }

    /**
     * 魔法函数__get
     *
     * @param  string $name  属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     *
     * @param  string $name   属性名称
     * @param  mixed  $value  属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * stop auto commit transaction and start a transaction
     *
     * @return void
     */
    static public function beginTransaction()
    {
        $instance = APP::$container->setSingle('DB', function () {
            return new DB();
        });
        $instance->dbInstance->beginTransaction();
    }

    /**
     * commit a transaction
     *
     * @return void
     */
    static public function commit()
    {
        $instance = APP::$container->setSingle('DB', function () {
            return new DB();
        });
        $instance->dbInstance->commit();
    }

    /**
     * rollback a transaction
     *
     * @return void
     */
    static public function rollBack()
    {
        $instance = APP::$container->setSingle('DB', function () {
            return new DB();
        });
        $instance->dbInstance->rollBack();
    }
}
