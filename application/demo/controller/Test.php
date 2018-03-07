<?php
namespace app\demo\controller;
use think\Controller;
class Test extends Controller
{
   public function sayGoodBye(){
      return $this->fetch("saygoodbye");
}
}