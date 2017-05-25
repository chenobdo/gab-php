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
use ReflectionClass;

/**
 * 注册加载handle
 */
class RouterHandle implements Handle
{
    /**
     * 框架实例
     * @var object
     */
    private $_app;

    public function __construct()
    {
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

    /**
     * 注册路由处理机制
     * @param  App    $app 框架实例
     * @return void
     */
    public function register(App $app)
    {
        $this->_app = $app;
        $this->route();
    }

    public function route()
    {
        // 普通路由策略


        // Pathinfo策略
        preg_match_all('/^\/(.*)\?/', $_SERVER['REQUEST_URI'], $uri);
        $uri = $uri[1][0];
        if (empty($uri)) {
            /**
             * 默认模块/控制器/操作逻辑
             */
            throw new Exception('NOT FOUND', 404);
        }
        $uri = explode('/', $uri);
        switch (count($uri)) {
        case 3 :
            $moduleName = $uri['0'];
              $controllerName = $uri['1'];
              $actionName = $uri['2'];
            break;
        case 2 :
            /**
                 * 默认模块
                 */

            break;
        case 1 :
            /**
                 * 默认模块/控制器
                 */

            break;
        default :
            /**
                 * 默认模块/控制器/操作逻辑
                 */
            break;
        }

        $controllerPath = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;
        $reflaction = new ReflectionClass($controllerPath);
        if(!$reflaction->hasMethod($actionName)) {
            throw new CoreHttpException(404, 'Action:' . $actionName);
        }
        $controller = new $controllerPath();
        $this->app->responseData  = $controller->$actionName();
    }
}
