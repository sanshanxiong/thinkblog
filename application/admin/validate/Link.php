<?php
/**
 * Created by PhpStorm.
 * User: qcx
 * Date: 2018/3/3
 * Time: 18:42
 */
namespace  app\admin\validate;
use think\Validate;
class Link extends Validate{

    protected $rule = [
        'name'  =>  'require|max:10|unique:link',
        'url' =>'require'
    ];
    protected $message = [
        'name.require'  =>  '必须填写链接名称',
        'name.max'  =>  '链接名必须小于10个字符',
        'name.unique'=>'链接名不能重复',
         'url.require'=>"必须填写链接地址"
    ];

    protected $scene = [
        'edit'   =>  ['name' ],
    ];
}