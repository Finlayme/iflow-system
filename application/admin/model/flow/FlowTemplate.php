<?php
/**
 * Created by PhpStorm.
 * User: Hety <Hetystars@gmail.com>
 * Date: 2021/7/30
 * Time: 14:14
 */

namespace app\admin\model\flow;


use think\Model;

/**
 * Class FlowTemplate
 * @package app\admin\model\flow
 */
class FlowTemplate extends Model
{
    // 表名
    protected $name = 'flow_template';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = true;
    protected $updateTime = false;

    // 追加属性
    protected $append = [

    ];
}