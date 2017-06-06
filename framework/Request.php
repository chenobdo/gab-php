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

use Framework\Exceptions\CoreHttpException;

/**
* 请求
*/
class Request
{
	/**
     * 请求模块
     * @var string
     */
    private $module = '';

    /**
     * 请求控制器
     * @var string
     */
    private $controller = '';

    /**
     * 请求操作
     * @var string
     */
    private $action = '';

    /**
     * 请求环境参数
     * @var array
     */
    private $serverParams = [];

    /**
    * 请求参数
    *
    * @var array
    */
    private $envParams = [];

    /**
     * 请求所有参数
     * @var array
     */
    private $requestParams = [];

    /**
     * 请求GET参数
     * @var array
     */
    private $getParams = [];

    /**
     * 请求POST参数
     * @var array
     */
    private $postParams = [];

    /**
     * http方法名称
     * @var string
     */
    private $method = '';

    /**
     * 服务ip
     * @var string
     */
    private $serverIp = '';

    /**
     * 客户端ip
     * @var string
     */
    private $clientIp = '';

    /**
     * 请求开始时间
     * @var float
     */
    private $beginTime = 0;

    /**
     * 请求结束时间
     * @var float
     */
    private $endTime = 0;

    /**
     * 请求消耗时间
     *
     * 毫秒
     *
     * @var int
     */
    private $consumeTime = 0;

    /**
     * 请求身份id
     *
     * 每个请求都赋予唯一的身份识别id，便于追踪问题
     *
     * @var string
     */
    private $requestId = '';

	/**
	 * 构造
	 */
	function __construct(App $app)
	{
		$this->serverParams = $_SERVER;
        $this->method       = isset($_SERVER['REQUEST_METHOD']) ?
            strtolower($_SERVER['REQUEST_METHOD']) : 'get';
        $this->serverIp     = isset($_SERVER['REMOTE_ADDR']) ?
            $_SERVER['REMOTE_ADDR'] : '';
        $this->clientIp     = isset($_SERVER['SERVER_ADDR']) ?
            $_SERVER['REMOTE_ADDR'] : '';
        $this->beginTime    = isset($_SERVER['REQUEST_TIME_FLOAT']) ?
            $_SERVER['REQUEST_TIME_FLOAT'] : time(true);
        if ($app->isCli === 'yes') {
            // cli 模式
            $this->requestParams = isset($_REQUEST['argv'])? : [];
            $this->getParams     = isset($_REQUEST['argv'])? : [];
            $this->postParams    = isset($_REQUEST['argv'])? : [];
        } else {
    		$this->requestParams = $_REQUEST;
    		$this->getParams = $_GET;
    		$this->postParams = $_POST;
        }
        // 加载环境参数
        $this->loadEnv($app);
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

    /**
     * 获取GET参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function get($value = '', $default = '', $checkEmpty = true)
    {
        if (!isset($this->getParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->getParams[$value]);
    }

    /**
     * 获取POST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function post($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->postParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->postParams[$value]);
    }

    /**
     * 获取REQUEST参数
     *
     * @param  string  $value      参数名
     * @param  string  $default    默认值
     * @param  boolean $checkEmpty 值为空时是否返回默认值，默认true
     * @return mixed
     */
    public function request($value = '', $default = '', $checkEmpty = true)
    {
        if (! isset($this->requestParams[$value])) {
            return '';
        }
        if (empty($this->getParams[$value]) && $checkEmpty) {
            return $default;
        }
        return htmlspecialchars($this->requestParams[$value]);
    }

    /**
     * 获取所有参数
     *
     * @return array
     */
    public function all()
    {
        $res = array_merge($this->postParams, $this->getParams);
        foreach ($res as &$v) {
            $v = htmlspecialchars($v);
        }
        return $res;
    }

    /**
     * 获取SERVER参数
     * @param  string $value 参数名
     * @return mixed
     */
    public function server($value = '')
    {
        return isset($this->serverParams[$value]) ? $this->serverParams[$value] : '';
    }

    /**
     * 获取env参数
     *
     * @param  string $value 参数名
     * @return mixed
     */
    public function env($value = '')
    {
        if (isset($this->envParams[$value])) {
            return $this->envParams[$value];
        }
        return '';
    }

    /**
     * 加载环境参数
     *
     * @param  App    $app 框架实例
     * @return void
     */
    public function loadEnv(App $app)
    {
        $env = parse_ini_file($app->rootPath . '/.env', true);
        if ($env === false) {
            throw CoreHttpException('load env fail', 500);
        }
        $this->envParams = array_merge($_ENV, $env);
    }

    /**
    * 参数验证
    *
    * 支持必传参数验证，参数长度验证，参数类型验证
    *
    * @param  string $paramName 参数名
    * @param  string $rule      规则
    * @return mixed
    */
    public function check($paramName = '', $rule = '', $length = 0)
    {
        if (! is_int($length)) {
            throw new CoreHttpException(400, "length type is not int");
        }

        if ($rule === 'require') {
            if (! empty($this->request($paramName))) {
                return;
            }
            throw new CoreHttpException(404, "param {$paramName}");
        }

        if ($rule === 'length') {
            if (strlen($this->request($paramName)) === $length) {
                return;
            }
            throw new CoreHttpException(400, "param {$paramName} length is not {$length}");
        }

        if ($rule === 'number') {
            if (is_numeric($this->request($paramName))) {
                return;
            }
            throw new CoreHttpException(400, "{$paramName} type is not number");
        }
    }
}
