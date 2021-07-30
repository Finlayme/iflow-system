<?php

namespace addons\webhook\provider;

use think\Request;

class Base
{
    /**
     * @var object|Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = Request::instance();
    }
}