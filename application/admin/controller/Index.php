<?php

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Session;

class Index extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->menu();
    }

    public function index()
    {
        $this->assign('web_title', '商城管理系统');
        return $this->fetch('index');
    }

    public function welcome()
    {
        $this->assign('web_title', '商城管理系统');
        return $this->fetch('welcome');
    }

    public function menu()
    {
        $roles_info = Session::get('admin')['roles'];
        $auth_ids = Db::table('role')->field('auth_ids')->where('id', 'in', $roles_info)->find();
        $authData = Db::table('auth')->field('id,auth_name,auth_link,pid')->select();
        $menuData = [];
        foreach ($authData as $key => &$value) {
            if ($value['pid'] === 0) {
                $menuData[] = $authData[$key];
            } else {
                foreach ($menuData as $k => &$val) {
                    if ($value['pid'] === $val['id']) {
                        $menuData[$k]['child'][] = $authData[$key];
                    }
                }
            }
        }
        $this->assign('menuData', $menuData);
        return $this->fetch('Layout/menu');
    }

}
