<?php
/**
 * Created by PhpStorm.
 * User: Hety <Hetystars@gmail.com>
 * Date: 2021/8/2
 * Time: 16:23
 */

namespace app\admin\validate\flow;

use think\Validate;

/**
 * Class Common
 * @package app\admin\validate\flow
 */
class CommonFlow extends Validate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
    ];

    /**
     * 提示消息
     * @var array
     */
    protected $message = [
    ];

    /**
     * 验证场景
     * @var array[]
     */
    protected $scene = [
        'add' => [],
        'edit' => [],
    ];
}