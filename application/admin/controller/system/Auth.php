<?php

namespace app\admin\controller\system;

use think\Db;
use app\admin\controller\Base;
use think\Request;

class Auth extends Base
{
    public function index()
    {
        $this->assign('web_title', '权限管理');
        return $this->fetch('auth/lists');
    }

    public function lists(Request $request)
    {
        $param = $request->param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 10;
        $pageIndex = ($page - 1) * $limit;
        $total = Db::table('auth')->count('id');
        $data = Db::table('auth')->limit($pageIndex, $limit)->select();
        return json(['code' => 0, 'data' => $data, 'msg' => '请求成功', 'count' => $total]);
    }


    public function add()
    {
        $authData = Db::table('auth')->field('id,auth_name,pid')->select();
        foreach ($authData as $key => &$value) {
            if ($value['pid'] !== 0) {
                $authData[$key]['auth_name'] = "&nbsp;&nbsp;&nbsp;▕▁▁&nbsp;" .  $authData[$key]['auth_name'];
            }
        }
        unset($value);
        $this->assign('auth_list', $authData);
        $this->assign('web_title', '添加权限');
        return $this->fetch('auth/add');
    }

    public function edit($edit_id = 0)
    {
        if (!empty($edit_id)) {
            $admin_data = Db::table('auth')->field('create_time,update_time', true)->where(['id' => $edit_id])->find();
            $this->assign('admin_data', $admin_data);
            $this->assign('web_title', '编辑');
            return $this->fetch('auth/edit');
        } else {
            return json(['code' => 404, 'msg' => '操作失败, 该用户不存在!']);
        }
    }

    public function delete($del_id = 0)
    {
        $result = Db::table('auth')->where('id', $del_id)->delete();
        if ($result !== false) {
            return json(['code' => 200, 'msg' => '已删除']);
        } else {
            return json(['code' => 404, 'msg' => '操作失败, 该用户不存在!']);
        }
    }
}
