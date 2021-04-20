<?php
/**
 * Create Time: 2021/3/29 15:38
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;


class Index extends Base
{
    public function index(){
        return $this->fetch('index');
    }
}