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

namespace App\Demo\Logics;

use Framework\App;

/**
 * 注册用户自定义执行的类
 */
class UserDefinedCase
{
	/**
	* 注册用户自定义执行的类
	*
	* @var aarray
	*/
    private $map = [
        //　演示 加载自定义网关
        'App\Demo\Logics\Gateway\Entrance'
    ];

    /**
     * 构造函数
     *
     * 初始化用户自定义类
     *
     * @param App $app 框架实例
     */
    public function __construct(App $app)
    {
        foreach ($this->map as $v) {
            new $v($app);
        }
    }
}
