<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/2/26
 * Time: 18:00
 */

namespace app\admin\controller\system;


use think\Db;
use think\Request;
use app\admin\controller\Base;

class Admin extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function index()
    {
        $this->assign('web_title', '管理员列表');
        return $this->fetch('admin/lists');
    }

    public function lists(Request $request)
    {
        $param = $request->param();
        $page = isset($param['page']) ? $param['page'] : 1;
        $limit = isset($param['limit']) ? $param['limit'] : 10;
        $pageIndex = ($page - 1) * $limit;
        $total = Db::table('role')->count('id');
        $data = Db::table('admin')->field('password', true)->limit($pageIndex, $limit)->select();
        return json(['code' => 0, 'data' => $data, 'msg' => '请求成功', 'count' => $total]);
    }

    public function add()
    {
        $data = Db::table('role')->field('id,role_name')->select();
        $this->assign('role_list', $data);
        $this->assign('web_title', '添加管理员');
        return $this->fetch('admin/add');
    }

    public function edit($edit_id = 0)
    {
        if (!empty($edit_id)) {
            $admin_data = Db::table('admin')->field('password', true)->where(['id' => $edit_id])->find();
            $role_data = Db::table('role')->field('id,role_name')->select();
            $this->assign('admin_data', $admin_data);
            $this->assign('role_list', $role_data);
            $this->assign('web_title', '编辑');
            return $this->fetch('admin/edit');
        } else {
            return json(['code' => 404, 'msg' => '操作失败, 该用户不存在!']);
        }
    }

    public function store(Request $request)
    {
        $param = $request->param();
        if (isset($param['id'])) {
            // update
            $param['update_time'] = date('Y-m-d H:i:s', time());
            $result = Db::table('admin')->where(['id' => $param['id']])->update($param);
            if ($result > 0) return json(['code' => 200, 'msg' => '更新成功']);
            if ($result === 0) return json(['code' => 404, 'msg' => '更新失败, 信息重复!']);
        } else {
            // add
            $admin_info = Db::table('admin')->field('username')->where(['username' => $param['username']])->find();
            if (isset($admin_info['username'])) {
                $data = [
                    'username' => $param['username'],
                    'password' => md5($param['password']),
                    'roles' => $param['roles'],
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'update_time' => date('Y-m-d H:i:s', time())
                ];
                Db::table('admin')->insert($data);
                return json(['code' => 200, 'msg' => '添加成功']);
            } else {
                return json(['code' => 405, 'msg' => '添加失败, 该用户已存在!']);
            }
        }
    }

    public function delete($del_id = 0)
    {
        $result = Db::table('admin')->where('id', $del_id)->delete();
        if ($result !== false) {
            return json(['code' => 200, 'msg' => '已删除']);
        } else {
            return json(['code' => 404, 'msg' => '操作失败, 该用户不存在!']);
        }
    }

}
