<?php
namespace app\index\controller;
use think\Controller;
class Test extends  Controller
{
    public function sayHello(){
         return $this->fetch("test\hello");
    }
}