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

class Redis
{
	public function __construct()
	{
		$config = App::$container->getSingle('config');
		$config = $config->config['nosql']['Redis'];
		$redis = new rootRedis();
		$redis->connect($config['root'], $config['port']);
		App::$container->setSingle('redis', $redis);
	}
}
