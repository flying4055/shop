<?php

namespace app\admin\controller\system;

use think\Db;
use app\admin\controller\Base;
use think\Request;

class Role extends Base
{
    public function index()
    {
        $this->assign('web_title', '角色管理');
        return $this->fetch('role/lists');
    }

    public function lists(Request $request)
    {
        $param = $request->param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 10;
        $pageIndex = ($page - 1) * $limit;
        $total = Db::table('role')->count('id');
        $data = Db::table('role')->limit($pageIndex, $limit)->select();
        return json(['code' => 0, 'data' => $data, 'msg' => '请求成功', 'count' => $total]);
    }

}
