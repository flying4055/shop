<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 19/2/26
 * Time: 15:24
 */

namespace app\admin\model;


use think\Model;

class Admin extends Model
{
    public function getRolesAttr($value)
    {
        return explode(',', $value);
    }
}

