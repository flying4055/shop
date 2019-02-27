<?php

namespace app\admin\controller\system;

use think\Db;
use app\admin\controller\Base;

class Auth extends Base
{
    public function index()
    {
        $this->assign('web_title', '权限管理');
        return $this->fetch('auth/lists');
    }


}
