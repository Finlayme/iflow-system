<?php

namespace app\common\controller;

use think\Config;
use think\Db;

/**
 * 后台控制器基类
 */
class FlowBackend extends Backend
{

    protected $model = null;
    protected $task = null;
    protected $flow = null;
    protected $currentNode = null;
    protected $nextNode = null;
    protected $scheme = null;
    protected $instance = null;
    protected $prefix = "";
    protected $adminModel = null;
    protected $number = null;

    public function _initialize()
    {
        $this->task = new \app\admin\model\flow\Task();
        $this->instance = new \app\admin\model\flow\Instance();
        $this->scheme = new \app\admin\model\flow\Scheme();
        $this->adminModel = new \app\admin\model\Admin();
        $this->number = new \app\admin\model\flow\Number();
        parent::_initialize();
        $this->prefix = Config::get('database.prefix');
    }

    /**
     * 保存草稿qq
     */
    public function save()
    {
        $params = $this->request->post("row/a");
        if ($this->request->isPost()) {
            if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                $params[$this->dataLimitField] = $this->auth->id;
            }
            try {
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->save($params);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * 直接提交流程
     */
    public function add()
    {
        $this->addHandle();
        return $this->view->fetch();
    }

    /**
     * @return $this
     */
    protected function addHandle()
    {
        $params = $this->request->post("row/a");
        $flowTmp = $this->scheme->get($this->request->request("ids"));
        if ($this->request->isPost()) {
            try {
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->start($params);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        $serial_no = $this->getnumber($flowTmp['flowcode']);
        $content = json_decode($flowTmp->flowcontent, true);
        $lines = $content['lines'];
        //所有节点信息
        $nodes = $content['nodes'] ?? [];
        $rtn = array_search('start', array_column(!is_null($nodes) ? $nodes : [], 'type'));
        $this->currentNode = $nodes[$rtn] ?? [];
        $fieldList = $this->getNodeField($this->request->request("ids"), $this->currentNode['id'], $flowTmp['bizscheme']);
        $this->view->assign("serial_no", $serial_no);
        $this->assignconfig('flowCode', $flowTmp['flowcode']);
        $this->view->assign('fieldList', $fieldList);
        return $this;
    }

    /**
     * 寻找下一个审批节点,同意按钮执行的方法
     */
    public function edit($ids = NULL)
    {
        $this->editHandle($ids);
        return $this->view->fetch();
    }

    protected function editHandle($ids)
    {
        $ids = $this->request->request('ids');
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        $taskid = $this->request->request('taskid');
        $task = null;
        $mode = $this->request->request('mode');
        if ($mode == 'view') {
            $task = $this->task->where(['id' => $taskid])->find();
        } else {
            $task = $this->task->where(['id' => $taskid])->where('status', 0)->find();
        }
        if (!$task)
            $this->error(__('找不到当前任务'));
        $schme = $this->scheme->get($task['flowid']);
        $instance = $this->instance->get($task['instanceid']);
        $originator = $this->adminModel->get($instance['originator']);
        if ($this->request->isPost()) {
            $comment = $this->request->post('comment') == '' ? '' : $this->request->post('comment');
            $data = $this->request->request("row/a");
            $data['id'] = $ids;
            try {
                //是否采用模型验证
                if ($this->modelValidate) {
                    $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                    $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                    $this->model->validate($validate);
                }
                $this->flow->next($taskid, $data, $comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        $history = Db::table($this->prefix . 'flow_task')
            ->alias('main')
            ->join($this->prefix . 'admin admin', 'admin.id=main.receiveid', 'LEFT')
            ->where(['instanceid' => $task['instanceid'], 'main.status' => 2])
            ->field(["main.receiveid", "main.stepname", "main.comment", "admin.nickname", "main.completedtime"])
            ->order('main.createtime asc,main.completedtime asc')
            ->select();
        //字段权限
        $fieldList = $this->getNodeField($task["flowid"], $task['stepid'], $schme['bizscheme'], 'view');
        $this->assignconfig('task', $task);
        $this->assignconfig('flowCode', $schme['flowcode']);
        $this->view->assign("history", $history);
        $this->view->assign("mode", $mode);
        $this->view->assign("instance", $instance);
        $this->view->assign("row", $row);
        $this->view->assign("originator", $originator);
        $this->view->assign("auth", $this->auth);
        $this->view->assign('fieldList', $fieldList);
        return $this;
    }

    /**
     * 拒绝流程
     */
    public function refuse()
    {
        if ($this->request->isPost()) {
            try {
                $taskid = $this->request->request('taskid');
                $comment = $this->request->post('comment');
                $this->flow->refuse($taskid, $comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
        return $this->view->fetch();
    }

    /**
     * 取消流程
     */
    public function cancel()
    {
        if ($this->request->isPost()) {
            try {
                $taskid = $this->request->request('taskid');
                $comment = $this->request->post('comment') == '' ? '[取消]' : $this->request->post('comment');
                $this->flow->cancel($taskid, $comment);
                $this->success();
            } catch (\think\exception\PDOException $e) {
                $this->error($e->getMessage());
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * 获取流水号
     */
    public function getnumber($code)
    {
        $row = $this->number->where(['code' => $code])->find();
        if (!$row) {
            return time();
        }
        $serial_no = '';
        $serial_no .= $row['pre'];
        if ($row['year'] == 'Y') {
            $serial_no .= Date('Y');
        }
        if ($row['month'] == 'Y') {
            $serial_no .= Date('m');
        }
        $serial_no .= str_pad($row['index'], $row['lengh'], "0", STR_PAD_LEFT);
        $row->allowField(true)->save(['index' => ($row['index'] + 1)]);
        return $serial_no;
    }

    /**
     * 获取节点授权字段默认是全部读
     */
    public function getNodeField($ids, $node, $code, $type = '')
    {
        $data = [];
        $fieldList = Db::name('flow_field')
            ->where(['node_id' => $node, 'flow_id' => $ids])
            ->select();

        if (!$fieldList) {
            $fieldList = Db::name('view_flow_field_default')
                ->where(['table_name' => $code, 'TABLE_SCHEMA' => Config::get('database.database')])
                ->select();
        }
        foreach ($fieldList as $item) {
            $data[$item['field']] = [
                'read' => $item['read'],
                'write' => $type == 'view' ? 0 : $item['write']
            ];
        }

        return $data;
    }
}
