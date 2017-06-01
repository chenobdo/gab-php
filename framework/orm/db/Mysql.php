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

namespace Framework\Orm\Db;

use Framework\App;
use Framework\Orm\DB;
use Framework\Exception\CoreHttpException;
use PDO;

/**
 * Mysql 实例类
 */
class Mysql
{
	private $dbhost   = '';
    private $dbname   = '';
    private $dns      = '';
    private $username = '';
    private $password = '';
    private $pdo = '';

    /**
     * 预处理实例
     *
     * 代表一条预处理语句，并在该语句被执行后代表一个相关的结果集。
     *
     * @var object
     */
    private $pdoStatement = '';

	public function __construct()
	{
		$config         = APP::$container->getSingle('config');
        $config         = $config->config;
        $dbConfig       = $config['database'];
        $this->dbhost   = $dbConfig['dbhost'];
        $this->dbname   = $dbConfig['dbname'];
        $this->dsn      = "mysql:dbname={$this->dbname};host={$this->dbhost};";
        $this->username = $dbConfig['username'];
        $this->password = $dbConfig['password'];

        $this->connect();
	}

	private function connect()
	{
		$this->pdo = new PDO(
            $this->dsn,
            $this->username,
            $this->password
        );
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

    public function findOne(DB $db)
    {
    	$this->pdoStatement = $this->pdo->prepare($b->sql);
    	$this->bindValue($db);
    	$this->pdoStatement->execute();
    	return $this->pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bindValue(DB $db)
    {
    	if (empty($db->params)) {
    		return;
    	}
    	foreach ($db->params as $k => $v) {
    		$this->pdoStatement->bindValue(":{$k}", $v);
    	}
    }
}
