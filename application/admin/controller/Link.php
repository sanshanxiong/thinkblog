<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/23
 * Time: 10:40
 */
namespace  app\admin\controller;
use think\Controller;
use app\admin\Model\Link as Url_Link;


class Link extends  Controller
{
    public function lst()
    {

        $linkObj = new Url_Link();
        $links = $linkObj->paginate(2);
        $this->assign('links',$links);
        return $this->fetch();
    }
    public function add(){

        //这里用到的request（） 和 input都是助手函数
        if(request()->isPost())/*post method */
        {
            //@1 获取数据
            $linkObj = new Url_Link();

            // 调用当前模型对应的User验证器类进行数据验证
            $result =$linkObj->validate(true)->save([
                'name'  =>  input('name'),
                'url' =>  input('url'),
                'show'=> empty(input('show'))?0:1
            ]);
            if(false === $result){
                // 验证失败 输出错误信息
                return $this->error("添加数据失败:".$linkObj->getError());
            }

            return $this->success("添加数据成功"."生产的id为".$linkObj->id,"lst");

        }
        return $this->fetch();
    }
    public function delete(){

        $id =input('id');
        $user = Url_Link::get($id);
        $ret = $user->delete();//delete 方法返回影响数据的条数，没有删除返回 0

        if($ret>0)
       {
           $this->success("删除成功","lst");
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
            //$category = Db::name('category')->where("id",$id)->find();//find 方法查询结果不存在，返回 null,默认情况下，find和select方法返回的都是数组。
            $linkObj = new Url_Link();
             // 查询单个数据
            $link = $linkObj->where('id', $id)->find();
            if($link!=null)
            {
                $this->assign("link",$link);
                return $this->fetch("edit");
            }
        }
        else
        {
            //@1 获取数据
            $data=[
                "name"=>input("name"),
                 "url" =>input('url'),
                "show"=>input("show")=="on"? 1:0,
                "id" =>input('id')

            ];
            $linkObj = new Url_Link();
            $result =$linkObj->validate("Link.edit")->save($data,['id'=>input("id")]);
            if(false === $result){
                // 验证失败 输出错误信息
                return $this->error("更新数据失败:".$linkObj->getError());
            }

            return $this->success("更新数据成功","lst");

        }

    }
}