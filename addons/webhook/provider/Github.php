<?php

namespace addons\webhook\provider;

use addons\webhook\exception\SignException;

/**
 * Class Github
 * Github 服务商
 * @package addons\webhook\controller
 */
class Github extends Base implements ProviderInterface
{
    /**
     * 签名
     * @param string $type 加密方式
     * @param string $ps 密码或签名密钥
     * @throws SignException
     */
    public function sign(string $type, string $ps)
    {
        throw new SignException(__('Illegal sign'));
    }
}