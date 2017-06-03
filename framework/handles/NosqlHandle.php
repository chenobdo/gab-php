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

namespace Framework\Handles;

use Framework\App;
use Framework\Handles\Handld;
use Framework\Exceptions\CoreHttpException;

/**
 *  nosql处理机制
 */
class NosqlHandle implements Handle
{
	public function __construct()
	{

	}

	/**
	 * 注册配置文件处理机制
	 * @param  App    $app 框架实例
	 * @return void
	 */
	public function register(App $app)
	{
		$config = $app::$container->getSingle('config');
        $config = explode(',', $config->config['nosql']);
        foreach ($config as $k => $v) {
            $className = 'Framework\Nosql\\' . ucfirst($v);
            new $className();
        }
	}
}
