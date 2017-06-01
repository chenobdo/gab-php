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
use Framework\Exceptions\CoreHttpException;
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
     * 是否输出响应结果
     *
     * 默认输出
     *
     * cli模式　访问路径为空　不输出
     *
     * @var boolean
     */
    private $notOutput = false;

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

    /**
     * 内部调用get 可构建微单体架构
     * @param  string $uri   要调用的path
     * @param  array  $argus 参数
     * @return void
     */
    public function get($uri = '', $argus = [])
    {
        return $this->callSelf('get', $uri, $argus);
    }

    /**
     * 内部调用post 可构建微单体架构
     * @param  string $uri   要调用的path
     * @param  array  $argus 参数
     * @return void
     */
    public function post($uri = '', $argus = [])
    {
        return $this->callSelf('post', $uri, $argus);
    }

    /**
     * 内部调用put 可构建微单体架构
     * @param  string $uri   要调用的path
     * @param  array  $argus 参数
     * @return void
     */
    public function put($uri = '', $argus = [])
    {
        return $this->callSelf('put', $uri, $argus);
    }

    /**
     * 内部调用delete 可构建微单体架构
     * @param  string $uri   要调用的path
     * @param  array  $argus 参数
     * @return void
     */
    public function delete($uri = '', $argus = [])
    {
        return $this->callSelf('delete', $uri, $argus);
    }

    /**
     * 内部调用 可构建微单体架构
     *
     * @param  string $method 方法
     * @param  string $uri 要调用的path
     * @param  array  $argus  参数
     * @return json
     */
    public function callSelf($method = '', $uri = '', $argus = [])
    {
        $requestUri = explode('/', $uri);
        if (count($requestUri) !== 3) {
            throw new CoreHttpException(400);
        }
        $request = self::$container->getSingle('request');
        $request->method = $method;
        $request->requestParams = $argus;
        $request->getParams     = $argus;
        $request->postParams    = $argus;
        $router = self::$container->getSingle('router');
        $router->moduleName = $requestUri[0];
        $router->controllerName = $requestUri[1];
        $router->actionName = $requestUri[2];
        $router->routeStrategy = 'microMonomer';
        $router->route();
        return $this->responseData;
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
        if ($this->notOutput === true) {
            return;
        }
        if ($this->isCli === 'yes') {
            $closure()->cliModeSuccess($this->responseData);
            return;
        }

        $closure()->restSuccess($this->responseData);
    }
}
