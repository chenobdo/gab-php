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
use MongoDB\Client;

class MongoDB
{
	public function __construct()
	{
		$config = App::$container->getSingle('config');
		$config = $config->config['mongoDB'];
		$client = new Client(
			"{$config['host']}:{$config['port']}",
			[
                'database' => $config['database'],
                'username' => $config['username'],
                'password' => $config['password']
            ]
		);
		$database = $client->selectDatabase($config['database']);
		App::$container->setSingle('mongoDB', $database);
	}
}
