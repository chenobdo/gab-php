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

/**
 * 自定义路由
 *
 * 支持restful风格
 */

$this->get('v1/user/info', function (Framework\App $app) {
    return 'Hello Get Router';
});

$this->post('v1/user/info', function (Framework\App $app) {
    return 'Hello Post Router';
});

$this->put('v1/user/info', function (Framework\App $app) {
    return 'Hello Put Router';
});

$this->delete('v1/user/info', function (Framework\App $app) {
    return 'Hello Delete Router';
});
