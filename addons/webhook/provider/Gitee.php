<?php

namespace addons\webhook\provider;

use addons\webhook\exception\SignException;

/**
 * Class Gitee
 * Gitee 服务商
 * @package addons\webhook\controller
 */
class Gitee extends Base implements ProviderInterface
{
    /**
     * 签名
     * @param string $type 加密方式
     * @param string $ps 密码或签名密钥
     * @throws SignException
     */
    public function sign(string $type, string $ps)
    {
        if (!method_exists($this, $type)) {
            throw new SignException(__('The encryption method does not exist'));
        }
        if (!$this->{$type}($ps)) {
            throw new SignException(__('Illegal sign'));
        }
    }

    /**
     * 密码验签
     * @param string $password
     * @return bool
     */
    private function password(string $password) : bool {
        $headerToken = $this->request->header('x-gitee-token');
        $paramToken = $this->request->param('password');
        if ($headerToken !== $paramToken) {
            return false;
        }
        return $headerToken === $password;
    }

    /**
     * 签名密钥验签
     * @param string $secret
     * @return bool
     */
    private function secret(string $secret) : bool {
        $xTimestamp = $this->request->header('x-gitee-timestamp');
        $xToken = $this->request->header('x-gitee-token');
        $timestamp = $this->request->param('timestamp');
        $sign = $this->request->param('sign');

        $header = $xTimestamp . $xToken;
        $param = $timestamp . $sign;
        if ($header !== $param) {
            return false;
        }
        $sign = base64_encode(hash_hmac('sha256', "$xTimestamp\n$secret", $secret, true));
        return $xToken === $sign;
    }
}