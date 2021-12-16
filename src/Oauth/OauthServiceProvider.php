<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:44:05 
 * @Last Modified by: wulin
 * @Last Modified time: 2021-12-16 09:45:21
 */

namespace QingYuan\Pdd\Oauth;

use Hanson\Foundation\Foundation;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class OauthServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['oauth.access_token'] = function (Foundation $pimple) {
            $accessToken = new AccessToken(
                $pimple->getConfig('client_id'),
                $pimple->getConfig('client_secret'),
                $pimple
            );
            $accessToken->setHttp($pimple->http);
            $accessToken->setRequest($pimple['request']);
            $accessToken->setRedirectUri($pimple->getConfig('redirect_uri'));

            return $accessToken;
        };

        $pimple['pre_auth'] = function ($pimple) {
            return new PreAuth($pimple);
        };

        $pimple['oauth'] = function ($pimple) {
            return new Oauth($pimple);
        };
    }
}
