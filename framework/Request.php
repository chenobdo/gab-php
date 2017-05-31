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
	 * 构造
	 */
	function __construct(App $app)
	{
		$this->serverParams = $_SERVER;
        if ($app->isCli === 'true') {
            // cli 模式
            $this->requestParams = $_REQUEST['argv'];
            $this->getParams     = $_REQUEST['argv'];
            $this->postParams    = $_REQUEST['argv'];
        } else {
    		$this->requestParams = $_REQUEST;
    		$this->getParams = $_GET;
    		$this->postParams = $_POST;
        }
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
        return $this->getParams[$value];
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
        return $this->postParams[$value];
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
        return $this->requestParams[$value];
    }

    /**
     * 获取所有参数
     *
     * @return array
     */
    public function all()
    {
        return $this->requestParams;
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
}
