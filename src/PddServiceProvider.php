<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:29:25 
 * @Last Modified by: wulin
 * @Last Modified time: 2021-12-16 09:32:11
 */
namespace QingYuan\Pdd;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Hanson\Foundation\Foundation;
class PddServiceProvider implements ServiceProviderInterface
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
        $pimple['access_token'] = function (Foundation $pimple) {
            return new AccessToken(
                $pimple->getConfig('client_id'),
                $pimple->getConfig('client_secret'),
                $pimple
            );
        };

        $pimple['api'] = function ($pimple) {
            return new Api($pimple);
        };
        $pimple['auth_api'] = function ($pimple) {
            return new Api($pimple, true);
        };
    }
}

