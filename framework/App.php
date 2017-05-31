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
    　* 框架加载流程一系列处理类集合
    　* @var array
    　*/
    private $handlesList = [];

    /**
     * 请求对象
     * @var object
     */
    private $request;

    /**
     * 响应对象
     * @var object
     */
    private $responseData;

    /**
     * 框架实例根目录
     *
     * @var string
     */
    private $rootPath;

    /**
     * cli模式
     *
     * @var string
     */
    private $isCli = 'false';

    /**
    * 框架实例
    *
    * @var object
    */
    public static $app;

    /**
    * 服务容器
    *
    * @var object
    */
    public static $container;

    /**
     * 构造
     *
     * @param string  $rootPath 框架实例根目录
     * @param Closure $loader   注入自加载实例
     */
    public function __construct($rootPath, Closure $loader)
    {
        // cli模式
        $this->isCli    = getenv('IS_CLI');
        // 根目录
        $this->rootPath = $rootPath;

        // 注册自加载
        $loader();
        Load::register($this);

        self::$app = $this;
        self::$container = new Container();
    }

    /**
     * 魔法函数__get
     * @param  string $name 属性名称
     * @return mixed
     */
    public function __get($name = '')
    {
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
        $this->$name = $value;
    }

    public function load(Closure $handle)
    {
        $this->handlesList[] = $handle;
    }

    public function run(Closure $request)
    {
        self::$container->setSingle('request', $request);
        foreach ($this->handlesList as $handle) {
            $instance = $handle();
            self::$container->setSingle(get_class($instance), $instance);
            $instance->register($this);
        }
    }

    public function response(Closure $closure)
    {
        $closure()->restSuccess($this->responseData);
    }
}
