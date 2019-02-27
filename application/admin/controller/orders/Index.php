<?php

namespace app\admin\controller\orders;

use think\Db;
use app\admin\controller\Base;

class Index extends Base
{
    public function index()
    {
        $this->assign('web_title', '角色管理');
        return $this->fetch('orders/lists');
    }


}
