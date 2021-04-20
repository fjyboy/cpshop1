<?php
/**
 * Create Time: 2021/3/30 15:10
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;


class User extends Base
{
    public function index(){
        $model=model('User');
        $list=$model->paginate(4);
        return $this->fetch('index',compact('list'));
    }
}