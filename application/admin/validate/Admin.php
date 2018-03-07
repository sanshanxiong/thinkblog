<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/3/5
 * Time: 9:35
 */
namespace  app\admin\validate;
use think\Validate;
class Admin extends  Validate
{
    protected $rule = [
        'username'  =>  'require|max:20|unique:admin|chsDash',
        'password' =>'require|alphaNum|length:4,15'
    ];
    protected $message = [
        'username.require'  =>  '用户名不可以为空',
        'username.max'  =>  '用户名不可以超过20',
        'username.unique'=>'用户名不能重复',
        'username.chsDash'=>'用户名只能是汉字、字母、数字和下划线_及破折号-',
        'password.require'=>"密码不能为空",
        'password.alphaNum'=>"密码值只能为字母和数字",
        'password.length'=>"密码长度在4~15个字符之间"
    ];

    protected $scene = [
        'edit'   =>  ['username' ],
    ];
}