<?php

namespace addons\flow;

use app\common\library\Menu;
use think\Addons;
use think\Console;
use think\Exception;

/**
 * 工作流插件
 */
class Flow extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
            [
                'name'    => 'flow',
                'title'   => '流程中心',
                'icon'    => 'fa fa-list',
                'sublist' => [
                    [
                        'name'   => 'flow/start',
                        'title'  => '发起流程',
                        'icon'   => 'fa fa-arrow-circle-o-right',
                        'weigh'  => 100,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/myworkitem',
                        'title'  => '待办任务',
                        'icon'   => 'fa fa-circle-o',
                        'weigh'  => 90,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/finishworkitem',
                        'title'  => '已办任务',
                        'icon'   => 'fa fa-gavel',
                        'weigh'  => 80,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/instance',
                        'title'  => '实例管理',
                        'icon'   => 'fa fa-apple',
                        'weigh'  => 70,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/scheme',
                        'title'  => '流程设计',
                        'icon'   => 'fa fa-database',
                        'weigh'  => 60,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/department',
                        'title'  => '部门管理',
                        'icon'   => 'fa fa-database',
                        'weigh'  => 50,
                        'ismenu' => 1
                    ],
                    [
                        'name'   => 'flow/deptuser',
                        'title'  => '组织架构',
                        'icon'   => 'fa fa-database',
                        'weigh'  => 40,
                        'ismenu' => 1
                    ], 
                    [
                        'name'   => 'flow/delegate',
                        'title'  => '委托代理',
                        'icon'   => 'fa fa-database',
                        'weigh'  => 30,
                        'ismenu' => 1
                    ],
                ],
                'remark'  => ''
            ],
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
        Menu::delete('flow');
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable('flow');
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable('flow');
        return true;
    }
    public function appInit($param)
    {
        if (request()->isCli()) {
            Console::addDefaultCommands([
                'app\admin\command\FlowCrud'
            ]);
        }
        //\think\Hook::add('action_begin', 'addons\\flow\\behavior\\flow');
    }

}
