<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/3/5
 * Time: 18:00
 */
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\Admin as Admin_M;
class Login extends  Controller{
    public function  login(){
         if(request()->isGet())
         {
             return $this->fetch();
         }
         $adimObj = new Admin_M();
         $user = $adimObj->where(['username'=>input('username')])->find();
         if($user)
         {
             if($user->password == md5(input('password')))
             {
                 session('user',$user);

                 return $this->success('用户登录成功','admin\index\index');//问题：如何返回上一页？
             }
             else
             {
                 return $this->error('用户名或密码错误');
             }
         }
         else
         {
             return $this->error('用户不存在');
         }
    }
    public function  logout()
    {
        // 清除session（当前作用域）
        session(null);
        return $this->success("请重新登录",'admin\login\login');
    }
}