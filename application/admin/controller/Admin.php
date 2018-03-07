<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/3/5
 * Time: 9:18
 */
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\Admin as Admin_M;
use think\Loader;
use think\Validate;
class Admin extends Controller {

    public function  lst(){
        $adminObj = new Admin_M();
        $admins = $adminObj->paginate(3);
        $this->assign('admins',$admins);
        return $this->fetch();
    }
    public function  add(){
        if(request()->isPost())
        {
            $adminObj = new Admin_M();
            $validate = Loader::validate('Admin');
            $data = [
                'username'  =>  input('username'),
                'password' =>  input('password')
            ];
            /*
             *  这里没有直接使用模型验证，是因为对于password要使用md5函数。而需要验证的是原始的输入数据
             *
             */
            if(!$validate->check($data)){

                // 验证失败 输出错误信息
                return $this->error($validate->getError());
            }

           $data['password']=md5($data['password']);
           $result = $adminObj->save($data);
           if($result>0){
               $this->success('添加数据成功，新数据id'.$adminObj->getLastInsID(),'lst');
            }
           else
               $this->error('添加数据大概因为数据库原因失败','lst');
        }
        return $this->fetch();
    }
    public function  edit(){
        if(request()->isPost())
        {
           $data=[
               'id'=>input('id'),
               'username'=>input('username'),
               'password'=>input('password')
           ];
           if(!empty($data['password']))
           {

               /* 验证密码是否正确*/
               $rules = [
                   'password' =>'require|alphaNum|length:4,15'
               ];
               $validate = new Validate($rules);
               $result   = $validate->check($data);
               if(false ===$result )
               {
                   return $this->error('修改密码错误:'.$validate->getError());
               }
               $data['password']=md5($data['password']);
               /*验证用户名是否错误*/
               $adminObj = new Admin_M();
               $result = $adminObj->validate("admin.edit")->save($data,['id'=>$data['id']]);
               if(false ===$result )
                   return $this->error('修改用户错误:'.$adminObj->getError());
               return $this->success('修改用户信息成功','lst');
           }
           else {
               unset($data['password']);
               /*验证用户名是否错误*/
               $adminObj = new Admin_M();
               $result = $adminObj->validate("admin.edit")->save($data,['id'=>$data['id']]);
               if(false ===$result )
                   return $this->error('修改用户错误:'.$adminObj->getError());
               return $this->success('修改用户信息成功','lst');
           }

        }
        else
        {
            $id =input('id');
            $user = Admin_M::get($id);
            $this->assign('admin',$user);
            return $this->fetch();
        }
     }
    public  function  delete()
     {
         $id=input('id');
         // 使用数组查询
         $user = Admin_M::get(['id' => $id]);
         if($user->username == "admin")
             $this->error('内置初始账号不可以删除','lst');
         else
         {
             $user->delete();
             $this->success('数据删除成功','lst');
         }
     }

}