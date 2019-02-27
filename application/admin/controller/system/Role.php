<?php

namespace app\admin\controller\system;

use think\Db;
use app\admin\controller\Base;

class Role extends Base
{
    public function index()
    {
        $this->assign('web_title', '角色管理');
        return $this->fetch('role/lists');
    }


}
