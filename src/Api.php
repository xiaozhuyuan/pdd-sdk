<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:44:18 
 * @Last Modified by:   wulin 
 * @Last Modified time: 2021-12-16 09:44:18 
 */
namespace QingYuan\Pdd;

use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    const URL = 'https://gw-api.pinduoduo.com/api/router';

    protected $pdd;
    protected $needToken;

    public function __construct(Pdd $pdd, $needToken = false)
    {
        $this->pdd = $pdd;
        $this->needToken = $needToken;
    }

    private function signature($params): string
    {
        ksort($params);
        $paramsStr = '';
        array_walk($params, function ($item, $key) use (&$paramsStr) {
            if ('@' != substr($item, 0, 1)) {
                $paramsStr .= sprintf('%s%s', $key, $item);
            }
        });

        return strtoupper(md5(sprintf('%s%s%s', $this->pdd['oauth.access_token']->getSecret(), $paramsStr, $this->pdd['oauth.access_token']->getSecret())));
    }

   
    public function auth(bool $auth = true): Api
    {
        $this->needToken = $auth;

        return $this;
    }

   
    public function request(string $method, array $params = [], string $data_type = 'JSON')
    {
        $http = $this->getHttp();
        $params = $this->paramsHandle($params);
        if ($this->needToken) {
            $params['access_token'] = $this->pdd['oauth.access_token']->getToken();
        }
        $params['client_id'] = $this->pdd['oauth.access_token']->getClientId();
        $params['sign_method'] = 'md5';
        $params['type'] = $method;
        $params['data_type'] = $data_type;
        $params['timestamp'] = strval(time());
        $params['sign'] = $this->signature($params);
        $response = call_user_func_array([$http, 'post'], [self::URL, $params]);
        $responseBody = strval($response->getBody());

        return strtolower($data_type) == 'json' ? json_decode($responseBody, true) : $responseBody;
    }

 
    protected function paramsHandle(array $params): array
    {
        array_walk($params, function (&$item) {
            if (is_array($item)) {
                $item = json_encode($item);
            }
            if (is_bool($item)) {
                $item = ['false', 'true'][intval($item)];
            }
        });

        return $params;
    }
}
