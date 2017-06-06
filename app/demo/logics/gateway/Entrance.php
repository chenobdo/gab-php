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

use Framework\App;
use App\Demo\Logics\Gateway\CheckAccessToken;
use App\Demo\Logics\Gateway\CheckFrequent;
use App\Demo\Logics\Gateway\CheckArguments;
use App\Demo\Logics\Gateway\CheckSign;
use App\Demo\Logics\Gateway\CheckAuthority;
use App\Demo\Logics\Gateway\CheckRouter;

/**
 * 网关入口实体
 *
 * 初始化网关
 *
 * 责任链模式实现的网关
 */
class Entrance
{
    public function __construct()
    {
    	 // 初始化一个：必传参数校验的check
        $checkArguments   =  new CheckArguments();
        // 初始化一个：令牌校验的check
        $checkAppkey      =  new CheckAppkey();
        // 初始化一个：访问频次校验的check
        $checkFrequent    =  new CheckFrequent();
        // 初始化一个：签名校验的check
        $checkSign        =  new CheckSign();
        // 初始化一个：访问权限校验的check
        $checkAuthority   =  new CheckAuthority();
        // 初始化一个：网关路由规则
        $checkRouter      =  new CheckRouter();

        // 构成对象链
        $checkArguments->setNext($checkAppkey)
                       ->setNext($checkFrequent)
                       ->setNext($checkSign)
                       ->setNext($checkAuthority)
                       ->setNext($checkRouter);

        // 启动网关
//        $checkArguments->start(
//            APP::$container->getSingle('request')
//        );
    }
}
