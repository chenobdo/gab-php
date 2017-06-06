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
use Framework\Handles\Handle;
use Framework\Exceptions\CoreHttpException;

/**
 * 用户自定义handle
 *
 * 用户可以自定义框架运行到路由前的操作
 *
 * @author Gabriel <https://github.com/obdobriel>
 */
class UserDefinedHandle implements Handle
{
	public function __construct()
	{}

	public function register(App $app)
	{
		// 获取配置
        $config  = $app::$container->getSingle('config');
        foreach ($config->config['module'] as $v) {
            $v = ucwords($v);
            // TODO
            $className = "\App\\{$v}\\Logics\UserDefinedCase";
            new $className($app);
        }
	}
}
