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
 * 检验app授权key
 */
class CheckAppkey extends Check
{
	public function doCheck(Request $request)
	{
		// 获取 app_key 配置
		$appKeyMap = $request->env('app_key_map');
		// app key
        $appKey    = $request->request('app_key');

        if (isset($appKeyMap[$appKey])) {
            return;
        }
        throw new CoreHttpException('app_key is not found', 404);
	}
}
