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
	function __construct()
	{
		$this->serverParams = $_SERVER;
		$this->requestParams = $_REQUEST;
		$this->getParams = $_GET;
		$this->postParams = $_POST;
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
     * @param  string $value 参数名
     * @return mixed
     */
    public function get($value = '')
    {
        return isset($this->getParams[$value]) ? $this->getParams[$value] : '';
    }

    /**
     * 获取POST参数
     * @param  string $value 参数名
     * @return mixed
     */
    public function post($value = '')
    {
        return isset($this->postParams[$value]) ? $this->postParams[$value] : '';
    }

    /**
     * 获取REQUEST参数
     * @param  string $value 参数名
     * @return mixed
     */
    public function request($value = '')
    {
        return isset($this->requestParams[$value]) ? $this->requestParams[$value] : '';
    }

    /**
     * 获取SERVER参数
     * @param  string $value 参数名
     * @return mixed
     */
    public function getServer($value = '')
    {
        return isset($this->serverParams[$value]) ? $this->serverParams[$value] : '';
    }
}
