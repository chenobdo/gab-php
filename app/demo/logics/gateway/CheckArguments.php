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

namespace App\Demo\Logics\Gateway;

use Framework\Request;
use App\Demo\Logics\Gateway\Check;
use Framework\Exceptions\CoreHttpException;

/**
 * 检验网关公共必传参数
 */
class CheckArguments extends Check
{
	/**
     * 网关参数
     *
     * common arguments
     *
     * @var
     */
    private $commonArgus = [
        // 签名 signature
        'sign',
        // 授权app key
        'app_key',
        // 毫秒级别时间戳
        'timestamp',
        // 12位随机字符串 round string len 12
        'nonce',
        // 设备id device id
        'device_id'
    ];

    public function doCheck(Request $request)
    {
    	// 获取所有参数
    	// get all params
    	$params = $request->all();

    	foreach ($this->commonArgus as $v) {
    		if (!isset($params[$v]) || empty($params[$v])) {
    			throw new CoreHttpException(
                    "Gateway's common argument [{$v}] is empty",
                    400
                );
    		}
    	}
    }
}
