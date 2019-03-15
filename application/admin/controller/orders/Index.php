<?php

namespace app\admin\controller\orders;

use think\Db;
use app\admin\controller\Base;
use think\Request;

class Index extends Base
{
    public function index()
    {
        $this->assign('web_title', '订单管理');
        return $this->fetch('orders/lists');
    }


    public function lists(Request $request)
    {
        $param = $request->param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 10;
        $pageIndex = ($page - 1) * $limit;
        $total = Db::table('orders')->count('id');
        $data = Db::table('orders')->limit($pageIndex, $limit)->select();
        return json(['code' => 0, 'data' => $data, 'msg' => '请求成功', 'count' => $total]);
    }

}
