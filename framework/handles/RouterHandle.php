<?php
/**
 * gab-php
 *
 * a light php framework for study
 *
 * @author: Gabriel <https://github.com/obdobriel>
 */

namespace Framework\Handles;

use Framework\Handles\Handle;
use Exception;
use ReflectionClass;
use Load;

/**
 * 注册加载handle
 */
class RouterHandle implements Handle
{
	public function __construct()
	{}

	public function register()
	{
		$this->route();
	}

	public function route()
	{
		preg_match_all('/^\/(.*)\?/', $_SERVER['REQUEST_URI'], $uri);

		echo "<pre>";
		echo "=================================";
		echo "<br >";
		echo "Filename: RouterHandle.php";
		echo "<br >";
		echo "Filepath: /C/Users/Gabriel/Documents/htdocs/gab-php/framework/handles/RouterHandle.php";
		echo "<br >";
		echo "=================================";
		var_dump($_SERVER['REQUEST_URI']);
		var_dump($uri);
		echo "<br >";
		exit("--------");


		$uri = $uri[1][0];
		if (empty($uri)) {
			throw new Exception('NOT FOUND', 404);
		}
		$uri = explode('/', $uri);
        if (count($uri) !== 3) {
            throw new Exception('BAD REQUEST', 400);
        }
        $moduleName = $uri['0'];
        $controllerName = $uri['1'];
        $actionName = $uri['2'];

        $controllerPath = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;
        $reflaction = new ReflectionClass($controllerPath);
        $methods = $reflaction->getMethods();
        if(!$reflaction->hasMethod($actionName)) {
            throw new Exception('ACTION NOT FOUND', 404);
        }
        $controller = new $controllerPath();
        $controller->$actionName();
	}
}
