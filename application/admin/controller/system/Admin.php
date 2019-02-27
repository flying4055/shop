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

    public function add()
    {
        $data = Db::table('role')->field('id,role_name')->select();
        $this->assign('role_list', $data);
        $this->assign('web_title', '添加管理员');
        return $this->fetch('admin/add');
    }

    public function store(Request $request)
    {
        $param = $request->param();
        if (isset($param['id'])) {
            // update
//            dump($param);
            return json(['code' => 200, 'msg' => '更新成功']);
        } else {
            // add
            $admin_info = Db::table('admin')->field('username')->find();
            if (!isset($admin_info['username'])) {
                $data = [
                    'username' => $param['username'],
                    'password' => md5($param['password']),
                    'roles' => $param['roles'],
                    'create_time' => date('Y-m-d H:i:s', time()),
                    'update_time' => date('Y-m-d H:i:s', time())
                ];
                Db::table('admin')->insert($data);
                return json(['code' => 200, 'msg' => '添加成功']);
            }
            return json(['code' => 405, 'msg' => '添加失败, 该用户已存在!']);
        }
    }


}
