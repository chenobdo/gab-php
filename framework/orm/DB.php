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
    private $dbtype  = '';

    /**
     * 数据库策略映射
     *
     * 目前只支持mysql
     *
     * @var array
     */
    private $dbStrategyMap  = [
        'mysql' => 'Framework\Orm\Db\Mysql'
    ];

    /**
     * db instance
     *
     * @var object
     */
    private $dbInstance;

    public function table($tableName = '')
    {
    	$db = new self;
    	$DB = App::$container->setSingle('DB', $db);
    	$DB->tableName = $tableName;
    	$DB->init();

    	return $DB;
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

    public function findOne()
    {
    	$this->select();
    	$this->bindSql();
    	$functionName = __FUNCTION__;
 		return $this->dbInstance->$functionName($this);
    }

    public function findAll()
    {
    	$this->select();
    	$this->bindSql();
    	$functionName = __FUNCTION__;
 		return $this->dbInstance->$functionName($this);
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

    public function __construct()
    {

    }
}
