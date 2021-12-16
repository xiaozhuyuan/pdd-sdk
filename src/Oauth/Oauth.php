<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:16:39 
 * @Last Modified by: wulin
 * @Last Modified time: 2021-12-16 09:41:54
 */

namespace QingYuan\Pdd\Oauth;

use QingYuan\Pdd\Pdd;

class Oauth
{
    /**
     * @var Pdd
     */
    private $app;

    public function __construct(Pdd $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $token
     * @param int    $expires
     *
     * @return Pdd
     */
    public function createAuthorization(string $token, int $expires = 86399): Pdd
    {
        $accessToken = new AccessToken(
            $this->app->getConfig('client_id'),
            $this->app->getConfig('client_secret')
        );

        $accessToken->setToken($token, $expires);

        $this->app->access_token = $accessToken;

        return $this->app;
    }
}
