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

namespace Framework;

use Framework\Container;
use Closure;

/**
 * application
 */
class App
{
    /**
     * 框架实例
     * @var object
     */
    public static $app;

    /**
    　* 框架加载流程一系列处理类集合
    　* @var array
    　*/
    private $_handlesList = [];

    /**
     * 服务容器
     * @var object
     */
    private $_container;

    /**
     * 请求对象
     * @var object
     */
    private $_request;

    /**
     * 响应对象
     * @var object
     */
    private $_responseData;

    /**
     * 构造
     */
    public function __construct()
    {
        self::$app = $this;
        $this->_container = new Container();
    }

    /**
     * 魔法函数__get
     * @param  string $name 属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
        $name = '_'.$name;
        return $this->$name;
    }

    /**
     * 魔法函数__set
     * @param  string $name  属性名称
     * @param  string $value 属性值
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $name = '_'.$name;
        $this->$name = $value;
    }

    public function load(Closure $handle)
    {
        $this->_handlesList[] = $handle;
    }

    public function run(Closure $request)
    {
        $this->_request = $request();
        foreach ($this->_handlesList as $handle) {
            $handle()->register($this);
        }
    }

    public function response(Closure $closure)
    {
        $closure()->restSuccess($this->_responseData);
    }
}
