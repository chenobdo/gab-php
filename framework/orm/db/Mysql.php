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
use Framework\Exception\CoreHttpException;
use PDO;

/**
 * Mysql 实例类
 */
class Mysql
{
	public function __construct()
	{
		$config = App::$container->getSingle('config');
		$config = $config->config;
		$dbConfig = $config['database'];
		$connect = "{$dbConfig['dbtype']}:dbname={$dbConfig['dbname']};host={$dbConfig['host']};";
		$pdo = new PDO(
			$connect,
			$dbConfig['username'],
			$dbConfig['password']
		);
	}
}
