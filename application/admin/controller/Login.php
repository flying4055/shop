<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/2/26
 * Time: 14:22
 */

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Session;

class Login extends Base
{
    protected function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $this->assign('title', '商城管理系统');
        return $this->fetch('index');
    }

    public function checkLogin(Request $request)
    {
        $param = $request->param();
        if (isset($param['username'])) {
            $res_user_info = Db::table('admin')->where('username', $param['username'])->find();
            if (!empty($res_user_info)) {
                if ($res_user_info['password'] === md5($param['password'])) {
                    $returnData = [
                        'id' => $res_user_info['id'],
                        'username' => $res_user_info['username'],
                        'avatar' => $res_user_info['avatar'],
                        'roles' => $res_user_info['roles'],
                        'update_time' => $res_user_info['update_time']
                    ];
                    Session::set('admin', $returnData);
                    return json(['code' => 200, 'msg' => '登录成功']);
                }
                return json(['code' => 404, 'msg' => '登录失败,用户名或密码不正确!!!']);
            }
            return json(['code' => 404, 'msg' => '登录失败,用户名或密码不正确!!!']);
        }
        return json(['code' => 400, 'msg' => '登录失败,请填写正确!!!']);
    }

}
