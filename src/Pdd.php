<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:44:40 
 * @Last Modified by: wulin
 * @Last Modified time: 2021-12-16 09:45:55
 */

namespace QingYuan\Pdd;

use Hanson\Foundation\Foundation;


class Pdd extends Foundation
{
    protected $providers = [
        PddServiceProvider::class,
        Oauth\OauthServiceProvider::class,
    ];
}