<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/2/23
 * Time: 19:20
 */
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:10|unique:category',
        'keywords' =>'require'
    ];
    protected $message = [
        'name.require'  =>  '必须填写分类名称',
        'name.max'  =>  '栏目名必须小于10个字符',
        'name.unique'=>'分类名不能重复'
    ];

    protected $scene = [
        'edit'   =>  ['name' ],
    ];
}