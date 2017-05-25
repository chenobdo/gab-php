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
* 响应
*/
class Response
{
	/**
	 * 构造
	 */
	function __construct()
	{
		# code...
	}

	/**
	 * 响应
	 * @param  mixed $response 响应内容
	 * @return josn
	 */
	public function response($response)
	{
		header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode(
            $response,
            JSON_UNESCAPED_UNICODE)
        );
	}

	/**
	 * REST风格 成功响应
	 * @param  mixed $response 响应内容
	 * @return josn
	 */
	public function restSuccess($response)
	{
		header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            'code'    => 200,
            'message' => 'OK',
            'result'  => $response
        ],JSON_UNESCAPED_UNICODE));
	}

	/**
	 * REST风格 失败响应
	 * @param  mixed $response 响应内容
	 * @param  integer $code
	 * @param  string  $message
	 * @return json
	 */
	public function restFail(
        $response,
		$code = 500,
        $message = 'Internet Server Error')
	{
		header('Content-Type:Application/json; Charset=utf-8');
        die(json_encode([
            'code'    => $code,
            'message' => $message,
            'result'  => $response
        ],JSON_UNESCAPED_UNICODE));
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
}
