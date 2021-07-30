<?php
/**
 * Created by PhpStorm.
 * User: Hety <Hetystars@gmail.com>
 * Date: 2021/7/30
 * Time: 11:49
 */

namespace app\admin\model\flow;

use think\Model;

/**
 * Class CommonFlowModel
 * @package app\admin\model\flow
 */
class CommonFlowModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $name = '';
    protected $table = 'fa_flow_nb';

    /**
     *自动写入时间戳字段
     * @var
     */
    protected $autoWriteTimestamp = false;

    /**
     * 定义时间戳字段名
     * @var
     */
    protected $createTime = false;
    protected $updateTime = false;

    /**
     * 追加属性
     * @var array
     */
    protected $append = [

    ];

    /**
     * @TODO 待完善
     * CommonFlowModel constructor.
     * @param $data
     */
    public function __construct($data = [])
    {
        if (empty($data['flow_code'])) {
            $data['flow_code'] = $_REQUEST['flow_code'] ?? '';
        }
        parent::__construct($data);
        $this->name = 'flow_' . $data['flow_code'] ?? '';
        $this->table = 'fa_flow_' . $data['flow_code'] ?? '';
    }

    /**
     * @param string $flowName
     * @return $this
     */
    public function setFlowName(string $flowName)
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getFlowName()
    {
        return $this->name;
    }

}