<?php
/*
 * @Author: wulin 
 * @Date: 2021-12-16 09:16:39 
 * @Last Modified by: wulin
 * @Last Modified time: 2021-12-16 09:40:48
 */

namespace QingYuan\Pdd\Oauth;

use QingYuan\Pdd\AccessToken as BaseAccessToken;
use Symfony\Component\HttpFoundation\Request;

class AccessToken extends BaseAccessToken
{
    /**
     * @var Request
     */
    protected $request;

    protected $redirectUri;

    /**
     * 获取 token from server.
     *
     * @param $params
     *
     * @return mixed
     */
    public function token($params)
    {
        $response = $this->getHttp()->json(self::TOKEN_API, $params);

        return json_decode(strval($response->getBody()), true);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
