<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

/**
 * 注册加载handle
 */
class Load
{
	/**
     * [__construct description]
     */
	public function __construct()
	{

	}

	/**
	 * 应用启动注册
	 * @param  [type] $load [description]
	 * @return [type]       [description]
	 */
	public function load($load)
	{
		spl_autoload_register([$this, 'autoload']);
	}

	private function autoload($class)
	{
		require ROOT_PATH  . '/' . str_replace('\\', '/', $class) . '.php';
	}
}
