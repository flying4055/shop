<?php

namespace app\admin\controller;

use think\Db;

class Auth extends Base
{
    public function index()
    {
        $this->assign('web_title', '权限管理');
        return $this->fetch('auth_list');
    }


}
