<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/28
 * Time: 8:52
 */
namespace app\admin\controller;
use think\Controller;
use think\Loader;
use think\Db;
class Article extends  Controller{
   public function lst(){
       //@1获取所有数据  这里的field其实没有实际用处，只是为了说明当字段重复时，如何处理.
       /* 这里演示的是C表所有都要，可以指定要某个
       field('a.* , c.name, c.id as cid, c.keywords as ckeywords')
field(  field('a.* ,c.name,c.id as cid, c.keywords as ckeywords')
       field('a.* ,c.name') //当然，这样写和不写是一样的。因为c表除了这个字段，其他字段与a重名了。所以name被保留，其他覆盖了。

       $articles = \think\Db::name('article')->alias('a')->field('a.* ,c.name')->join('category c','a.cateid = c.id','left')->select();

       */
       //$articles = \think\Db::name('article')->alias('a')->field('a.* ,c.name')->join('category c','a.cateid = c.id','left')->select();
       $articles = \think\Db::name('article')->alias('a')->field('a.* ,c.name')
           ->join('category c','a.cateid = c.id','left')->paginate(2);
       //@2传递给视图
       $this->assign('articles',$articles);
       return $this->fetch();
   }
   public function add(){
       if(request()->isPost())
       {
          //@1.1获取到form数据
           $data=[
              'title'=>input('title'),
              'keywords'=>input('keywords'),
              'descs'=>input('descs'),
              'click'=>0,
              'time'=>time(),
               'content'=>input('content'),
               'cateid'=>input('cateid')
          ];
           //@1.2 获取form中上传的数据
           // 获取表单上传文件 例如上传了001.jpg
           $file = request()->file('pic');
           if(!empty($file))
           {
               // 移动到框架应用根目录/public/uploads/ 目录下
               $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
               if($info)
               {
                   $data['pic']=$info->getSaveName();
                   $data['pic']=date('Ymd')."/".$info->getFilename();
               }
               else
               {
                   // 上传失败获取错误信息
                   return $this->error($file->getError());
               }

           }

          //@2校验获取到的数据
           $validater =Loader::validate('Article') ;
           if(!$validater->check($data))//如果验证失败，则显示错误信息
           {
               return $this->error("数据校验错误".$validater->getError());
           }
           //@3写入数据库
           $ret =Db::name('article')->insert($data);//insert 方法添加数据成功返回添加成功的条数，insert 正常情况返回 1
           if($ret ==1)
           {
               return $this->success("添加文章成功","lst");
           }
           else
               return $this->error("添加文章失败");
          return;
       }
       $categories = Db::name('category')->select();
       $this->assign("categories",$categories);
       return $this->fetch();

   }
   public  function  edit()
   {
       if(request()->isPost())
       {
            //@1.1获取到form数据
           $data=[
               'title'=>input('title'),
               'keywords'=>input('keywords'),
               'descs'=>input('descs'),
               'endtime'=>input('endtime'),
               'content'=>input('content'),
               'cateid'=>input('cateid'),
               'id'=>input('id')
           ];
          if(!empty($data['endtime']))
            $data['endtime']=strtotime($data['endtime']);
          $data['endtime']=time();
           //@1.2 获取form中上传的数据
           // 获取表单上传文件 例如上传了001.jpg
           $file = request()->file('pic');
           if(!empty($file))
           {
               // 移动到框架应用根目录/public/uploads/ 目录下
               $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
               if($info)
               {
                   $data['pic']=$info->getSaveName();
                   //$data['pic']=date('Ymd')."/".$info->getFilename();
               }
               else
               {
                   // 上传失败获取错误信息
                   return $this->error($file->getError());
               }

           }

           //@2校验获取到的数据
           $validater =Loader::validate('Article') ;
           if(!$validater->check($data))//如果验证失败，则显示错误信息
           {
               return $this->error("数据校验错误".$validater->getError());
           }
           //@3写入数据库
           $ret =Db::name('article')->update($data);//insert 方法添加数据成功返回添加成功的条数，insert 正常情况返回 1
           if($ret ==1)
           {
               return $this->success("修改文章成功","lst");
           }
           else
               return $this->error("修改文章失败");
           return;

       }
       else
       {
           $id=input('id');
           $categories = Db::name('category')->select();
           $article = Db::name('article')->where("id",$id)->find();
           if($article!=null) {
               $this->assign("categories", $categories);
               $this->assign("article", $article);
               return $this->fetch();
           }
       }
   }
   public function delete()
   {

       $id =input('id');
       $ret = Db::name('article')->delete($id);

       if($ret>0)
       {
           $this->success("文章删除成功","lst");
       }
       else
       {
           $this->error("文章删除失败");
       }
   }
}