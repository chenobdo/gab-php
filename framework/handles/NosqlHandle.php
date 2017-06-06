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
 *  nosql handle
 */
class NosqlHandle implements Handle
{
	/**
	 * [__construct description]
	 */
	public function __construct()
	{
	}

	/**
	 * register nosql handle
	 *
	 * @param  App    $app 框架实例
	 * @return void
	 */
	public function register(App $app)
	{
		$config = $app::$container->getSingle('config');
		if (empty($config->config['nosql'])) {
            return;
        }
        $config = explode(',', $config->config['nosql']);
        foreach ($config as $k => $v) {
            $className = 'Framework\Nosql\\' . ucfirst($v);
            App::$container->setSingle($v, function () use ($className) {
                // 懒加载　lazy load
                return $className::init();
            });
        }
	}
}
