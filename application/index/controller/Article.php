<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/17
 * Time: 18:39
 */
namespace  app\index\controller;
use think\Controller;
class Article  extends  Controller{
    public function  index(){
        return $this->fetch("article");
    }
    public function test(){
        return $this->fetch("common/test");
    }

}