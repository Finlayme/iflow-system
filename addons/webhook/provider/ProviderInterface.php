<?php

namespace addons\webhook\provider;

interface ProviderInterface
{
    /**
     * 签名
     * @param string $type 加密类型
     * @param string $ps 密码或签名密钥
     */
    public function sign(string $type, string $ps);
}