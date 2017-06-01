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
use Framework\Exceptions\CoreHttpException;
use ReflectionClass;
use Closure;

/**
 * 注册加载handle
 */
class RouterHandle implements Handle
{
    /**
     * 框架实例.
     *
     * @var App
     */
    private $app;

    /**
     * 配置实例
     *
     * @var
     */
    private $config;

    /**
     * 默认模块.
     *
     * @var string
     */
    private $moduleName = '';

     /**
      * 默认控制器.
      *
      * @var string
      */
    private $controllerName = '';

    /**
     * 默认操作.
     *
     * @var string
     */
    private $actionName = '';

    /**
     * 默认操作.
     *
     * @var string
     */
    private $routeStrategy = '';

    /**
     * 请求uri.
     *
     * @var string
     */
    private $requestUri = '';

    /**
     * 自定义路由规则 get请求
     * @var array
     */
    private $getMap = [];

    /**
     * 自定义路由规则 post请求
     * @var array
     */
    private $postMap = [];

    /**
     * 自定义路由规则 put请求
     * @var array
     */
    private $putMap = [];

    /**
     * 自定义路由规则 delete请求
     * @var array
     */
    private $deleteMap = [];

    /**
     * 构造函数.
     */
    public function __construct()
    {
        // code...
    }

    /**
     * 魔法函数__get.
     *
     * @param string $name 属性名称
     *
     * @return mixed
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set.
     *
     * @param string $name  属性名称
     * @param mixed  $value 属性值
     *
     * @return mixed
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

     /**
     * 自定义get请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function get($uri = '', $function = '')
    {
        $this->getMap[$uri] = $function;
    }

    /**
     * 自定义post请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function post($uri = '', $function = '')
    {
        $this->postMap[$uri] = $function;
    }

    /**
     * 自定义put请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function put($uri = '', $function = '')
    {
        $this->putMap[$uri] = $function;
    }

    /**
     * 自定义delete请求路由
     *
     * @param  string $uri      请求uri
     * @param  mixed  $function 匿名函数或者控制器方法标示
     * @return void
     */
    public function delete($uri = '', $function = '')
    {
        $this->deleteMap[$uri] = $function;
    }

    /**
     * 注册路由处理机制
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        // 注入当前对象到容器中
        $app::$container->setSingle('router', $this);
        // request uri
        $this->requestUri = $app::$container->getSingle('request')->server('REQUEST_URI');
        // App
        $this->app = $app;
        // 获取配置
        $config = $app::$container->getSingle('config');
        // 设置默认模块
        $this->moduleName     = $config->config['route']['default_module'];
        // 设置默认控制器
        $this->controllerName = $config->config['route']['default_controller'];
        // 设置默认操作
        $this->actionName     = $config->config['route']['default_action'];

        /* 路由策略　*/
        $this->routeStrategy = 'pathinfo';
        if (strpos($this->requestUri, 'index.php') || $app->isCli === 'yes') {
            $this->routeStrategy = 'general';
        }

        // 开启路由
        $this->route();
    }

    /**
     * 路由机智
     * @return void
     */
    public function route()
    {
        // 路由策略
        $strategy = $this->routeStrategy;
        $this->$strategy();

        // 自定义路由判断
        if ($this->userDefined()) {
            return;
        }

        // 判断模块存不存在
        if (! in_array(strtolower($this->moduleName), $this->config->config['module'])) {
            throw new CoreHttpException(404, 'Module:'.$this->moduleName);
        }

        // 获取控制器类
        $controllerName = ucfirst($this->controllerName);
        $moduleName = ucfirst($this->moduleName);
        $controllerPath = "App\\{$moduleName}\\Controllers\\{$controllerName}";

        // 判断控制器存不存在
        if (!class_exists($controllerPath)) {
            throw new CoreHttpException(404, 'Controller:'.$controllerName);
        }

        // 反射解析当前控制器类　判断是否有当前操作方法
        $reflaction     = new ReflectionClass($controllerPath);
        if(!$reflaction->hasMethod($this->actionName)) {
            throw new CoreHttpException(404, 'Action:' . $this->actionName);
        }
        // 实例化当前控制器
        $controller = new $controllerPath();
        // 调用操作
        $actionName = $this->actionName;
        // 获取返回值
        $this->app->responseData  = $controller->$actionName();
    }

    /**
     * 普通路由
     * @return void
     */
    public function general()
    {
        $app = $this->app;
        $request = $app::$container->getSingle('request');
        $moduleName = $request->request('module');
        $controller = $request->request('controller');
        $actionName     = $request->request('action');
         if (! empty($moduleName)) {
             $this->moduleName = $moduleName;
         }
         if (! empty($controllerName)) {
             $this->controllerName = $controllerName;
         }
         if (! empty($actionName)) {
             $this->actionName = $actionName;
         }
    }

    /**
      * pathinfo url路径
      *
      * @return void
      */
    public function pathinfo()
    {
        if (strpos($this->requestUri, '?')) {
            preg_match_all('/^\/(.*)\?/', $this->requestUri, $uri);
        } else {
            preg_match_all('/^\/(.*)/', $this->requestUri, $uri);
        }

        // 使用默认模块/控制器/操作逻辑
        if (!isset($uri[1][0]) || empty($uri[1][0])) {
            // CLI 模式不输出
            if ($this->app->isCli === 'yes') {
                $this->app->notOutput = true;
            }
            return;
        }
        $uri = $uri[1][0];
        $uri = explode('/', $uri);
        switch (count($uri)) {
            case 3:
                $this->moduleName     = $uri['0'];
                $this->controllerName = $uri['1'];
                $this->actionName     = $uri['2'];
                break;

            case 2:
                /**
                 * 默认模块
                 */
                 $this->controllerName = $uri['0'];
                 $this->actionName     = $uri['1'];
                 break;
            case 1:
                /**
                 * 默认模块/控制器
                 */
                 $this->actionName     = $uri['0'];
                 break;

            default:
                /**
                 * 默认模块/控制器/操作逻辑
                 */
                 break;
        }
    }

     /**
     * 自定义路由
     * @return void
     */
    private function userDefined()
    {
        $module = $this->config['module'];
        foreach ($module as $V) {
            // 加载自定义路由配置文件
            $routeFile = "{$this->app->rootPath}/config/{$v}/route.php";
            if (file_exists($routeFile)) {
                require($routeFile);
            }
        }

        // 路由匹配
        $uri = "{$this->moduleName}/{$this->controllerName}/{$this->actionName}";
        if (!array_key_exists($uri, $this->getMap)) {
            return false;
        }

        // 执行自定义路由匿名函数
        $app     = $this->app;
        $request = $app::$container->getSingle('request');
        $method  = $request->method . 'Map';
        if (!isset($this->$method)) {
            throw new CoreHttpException(404, 'Http Method:'. $request->method);
        }
        $map = $this->$method;
        $this->app->responseData = $map[$uri]($app);
        if ($this->app->isCli === 'yes') {
            $this->app->notOutput = false;
        }
        return true;
    }

    /**
     * APP内部调用　可构建微单体架构
     *
     * @return void
     */
    public function microMonomer()
    {
        # do nothing...
    }
}
