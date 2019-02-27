<?php

namespace app\admin\controller;

use think\Db;

class Role extends Base
{
    public function index()
    {
        $this->assign('web_title', '角色管理');
        return $this->fetch('roles_list');
    }


}
