<?php
/**
 * Created by PhpStorm.
 * User: Hety <Hetystars@gmail.com>
 * Date: 2021/7/30
 * Time: 11:29
 */

namespace app\admin\controller\flow;

use app\{admin\model\flow\CommonFlowModel,
    admin\model\flow\FlowTemplate,
    common\controller\FlowBackend,
    common\library\FlowEngine
};
use think\db\exception\DataNotFoundException;
use think\Exception;
use think\Model;

/**
 * Class CommonFlow
 * @package app\admin\controller\flow
 */
class Commonflow extends FlowBackend
{

    /**
     * flow模型对象
     * @var Model
     */
    protected $model = null;

    /**
     * @var string[]
     */
    protected $noNeedRight = ['*'];


    /**
     * 是否开启Validate验证
     */
    protected $modelValidate = true;


    /**
     * @var string
     */
    protected $flowCode;

    /**
     * @throws Exception
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->flowCode = strtolower($this->request->request("flow_code"));
        $this->model = new CommonFlowModel(['flow_code' => $this->flowCode]);
        $this->flow = new FlowEngine($this->flowCode);
    }

    /**
     * 直接提交流程
     */
    public function add()
    {
        $this->addHandle();
        $template = $this->getFlowTemplate($this->flowCode, __FUNCTION__);
        return $this->view->fetch($template, [], [], [], true);
    }

    /**
     * 寻找下一个审批节点,同意按钮执行的方法
     */
    public function edit($ids = NULL)
    {
        $this->editHandle($ids);
        $template = $this->getFlowTemplate($this->flowCode, __FUNCTION__);
        return $this->view->fetch($template, [], [], [], true);
    }

    /**
     * @param string $flowCode
     * @param string $viewType
     * @return array|bool|float|int|mixed|object|\stdClass|string
     * @throws \think\exception\DbException
     */
    protected function getFlowTemplate(string $flowCode, string $viewType)
    {
        $result = FlowTemplate::get(['flow_code' => $flowCode, 'view_type' => $viewType], [], false);
        if (empty($result['template'])) {
            throw new DataNotFoundException($flowCode . ' template is not existed');
        }
        return $result['template'];
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}