<?php

namespace app\admin\controller;

use think\Db;

class Index extends Base
{
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
        $rolesData = Db::table('role')->whereIn('id','in','1,2,3')->select();
        dump($rolesData);

        die();
        $this->assign('sider_menu', '商城管理系统');
        return $this->fetch('Layout/menu');
    }

}
