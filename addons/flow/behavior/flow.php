<?php

namespace addons\flow\behavior;

use app\admin\library\Auth;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\Log;
use think\Session;
use app\common\library\FlowEngine;

/**
 *
 */
class Flow
{

    public function run()
    {

    }

    public function actionBegin()
    {
        $action = ['add'];
        if (request()->module() != 'admin' || !request()->isPost() || in_array(request()->action(), $action)) {
            return true;
        }

        $data_id = request()->param('ids');
        $controller = request()->controller();
        $controller = strtolower(str_replace(['/', '.'], '\\', $controller));

        if (request()->action() == 'add') {

            try {

                // 查找对应数据库是否开启回收站
                $recycle = Db::name('flow_table')
                    ->where('status', '1')
                    ->where('controller_as', $controller)
                    ->order('createtime desc')
                    ->find();

                $flowModel = new FlowEngine('leave');
                $flowModel->start([]);


            } catch (PDOException $e) {
                Log::record('[ DataSecurity ]' . var_export($e, true), 'notice');
            } catch (Exception $e) {
                Log::record('[ DataSecurity ]' . var_export($e, true), 'notice');
            }

            return true;
        }
    }
}