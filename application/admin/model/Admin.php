<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/3/5
 * Time: 9:28
 */
namespace  app\admin\model;
use think\Model;
class Admin extends Model{
    //方法本身没问题，只是后来我想把功能写到控制器中了
    /*public function  login($username,$password){
        $user = $this->where(['username'=>$username])->find();
        if($user)
        {
            if($user->password == md5($password)) //用户名密码都对
                return 1;
            else
                return -2; //密码错误返回-2
        }
        else
        {
            return -1; //用户不存在返回-1
        }
    }*/
}