<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/2/26
 * Time: 18:00
 */

namespace app\admin\controller;


use think\Db;
use think\Request;

class Admin extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function index()
    {
        $this->assign('web_title', '管理员列表');
        return $this->fetch('admin_list');
    }

    public function admin_lists(Request $request)
    {
        $param = $request->param();
        if (isset($param['page']) && isset($param['limit'])) {
            $page = $param['page'];
            $limit = $param['limit'];
            $pageIndex = ($page - 1) * $limit;
        }
        $data = Db::table('admin')->field('password', true)->limit($pageIndex, $limit)->select();
        return json(['code' => 0, 'data' => $data, 'msg' => '请求成功']);
    }

}
