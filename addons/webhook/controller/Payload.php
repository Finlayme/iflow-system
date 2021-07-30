<?php

namespace addons\webhook\controller;

use addons\webhook\library\Command;
use addons\webhook\provider\Gitee;
use addons\webhook\provider\Github;
use addons\webhook\provider\ProviderInterface;
use app\admin\model\webhook\Record;
use think\addons\Controller;
use think\Exception;

class Payload extends Controller
{
    const PROVIDER = [
        'gitee'  => Gitee::class,
        'github' => Github::class
    ];

    /**
     * WebHook 有效荷载
     * @return string
     */
    public function index(): string
    {
        $model = new Record();
        $status = 0;
        $config = get_addon_config('webhook');
        try {
            $provider = $this->getProviderObj($config['provider']);
            $provider->sign($config['type'], $config['ps']);
            $result = Command::execute();
            $status = 1;
            $result = implode("\n", $result);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        $model->save([
            'provider'      => $config['provider'],
            'type'          => $config['type'],
            'request_data'  => json_encode($this->request->param()),
            'header_data'   => json_encode($this->request->header()),
            'response_data' => $result,
            'status'        => $status
        ]);
        return $result;
    }

    /**
     * 获取服务商实例对象
     * @param string $provider
     * @return ProviderInterface
     * @throws Exception
     */
    public function getProviderObj(string $provider): ProviderInterface
    {
        $class = self::PROVIDER[$provider];
        $obj = new $class();
        if (null === $obj || !$obj instanceof ProviderInterface) {
            throw new Exception(__('The service provider is not defined or not regulated'));
        }
        return $obj;
    }
}