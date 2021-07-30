<?php

namespace addons\webhook;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Webhook extends Addons
{
    protected $addonMenuName = 'webhook/record';

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            [
                'name'    => $this->addonMenuName,
                'title'   => 'WebHook请求记录',
                'icon'    => 'fa fa-yelp',
                'sublist' => [
                    [ 'name' => 'webhook/record/index', 'title' => '查看' ],
                    [ 'name' => 'webhook/record/show', 'title' => '显示数据' ],
                ]
            ]
        ];
        Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete($this->addonMenuName);
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable($this->addonMenuName);
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable($this->addonMenuName);
        return true;
    }
}
