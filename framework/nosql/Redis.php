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

namespace Framework\Nosql;

use Framework\App;
use Redis as rootRedis;

/**
 * Redis class
 */
class Redis
{
	/**
	 * Init redis
	 */
	static public function init()
	{
		$config = App::$container->getSingle('config');
		$config = $config->config['redis'];
		$redis = new rootRedis();
		$redis->connect($config['host'], $config['port']);
		return $redis;
	}
}
