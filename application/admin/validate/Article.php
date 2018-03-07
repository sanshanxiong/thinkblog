<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/23
 * Time: 19:20
 */
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
    protected $rule = [
        'title'  =>  'require|max:100|unique:Article',
        'keywords' =>'require'

    ];
    protected $message = [
        'title.require'  =>  '必须填写文章名称',
        'title.max'  =>  '文章名必须小于100个字符',
        'title.unique'=>'文章名不能重复',
        'keywords'=>"关键字不可以为空"

    ];


}