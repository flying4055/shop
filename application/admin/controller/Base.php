<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->checkLoginStatus();
    }

    public function checkLoginStatus()
    {
        $adminStatus = Session::get('admin');
        if (empty($adminStatus)) {
            $this->error('您还未登录,请登录后访问', '/admin/login/index');
        }
    }
}
