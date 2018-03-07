<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/23
 * Time: 10:40
 */
namespace  app\admin\controller;
use think\Controller;
use think\Db;
use think\Loader;

class Category extends  Controller
{
    public function lst()
    {


       $categories=  Db::name('category')->paginate(2);
       $this->assign('categories',$categories);
       return $this->fetch();
    }
    public function add(){
        //这里用到的request（） 和 input都是助手函数
        if(request()->isPost())/*post method */
        {
            //@1 获取数据
            $data=[
                "name"=>input("name"),
                "keywords"=>input("keywords"),
                "type"=>input("type"),
                "descs"=>input("descs")
                /*,"qcx"=>$_POST['name'] 这里仅用来说明以往的方式也是可用的*/
            ];
            /*
            输出以上的数据，看看有无错
            var_dump($data);
            die();
            */
            // @2 校验数据
            $validate = Loader::validate("Category");//或直接使用助手函数validate('User');
            //如果验证失败，则显示错误信息
            if(!$validate->check($data)){
                return $this->error("添加数据失败:".$validate->getError());
            }
            //@2 写入数据库
            $ret = Db::name("category")->insert($data);
            if($ret)
               return $this->success("添加数据成功","lst");
            else
                return $this->error("添加数据失败");
        }
        return $this->fetch();
    }
    public function delete(){

        $id =input('id');
       $ret = Db::name('category')->delete($id);//delete 方法返回影响数据的条数，没有删除返回 0

        if($ret>0)
       {
           $this->success("栏目删除成功","lst");
       }
       else
       {
           $this->error("删除数据失败");
       }
    }
    public function  edit()
    {
        if(request()->isGet())
        {
            $id =input('id');
            $category = Db::name('category')->where("id",$id)->find();//find 方法查询结果不存在，返回 null,默认情况下，find和select方法返回的都是数组。
            if($category!=null)
            {
                $this->assign("category",$category);
                return $this->fetch("edit");
            }
        }
        else
        {
            //@1 获取数据
            $data=[
                "name"=>input("name"),
                "keywords"=>input("keywords"),
                "type"=>input("type")=="on"? 1:0,
                "descs"=>input("descs"),
                "id"=>input("id")
                /*,"qcx"=>$_POST['name'] 这里仅用来说明以往的方式也是可用的*/
            ];
            /*
            //输出以上的数据，看看有无错
            var_dump($data);
            die();
            */
            // @2 校验数据
            $validate = Loader::validate("Category");//或直接使用助手函数validate('User');
            //如果验证失败，则显示错误信息 场景验证
            if(!$validate->scene('edit')->check($data)){
                return $this->error("修改数据失败:".$validate->getError());
            }
            //@2 写入数据库
            $ret = Db::name("category")->update($data);//update 方法返回影响数据的条数，没修改任何数据返回 0
            if($ret>=0)
                return $this->success("修改数据成功","lst");
            else
                return $this->error("修改数据失败");
        }

    }
}