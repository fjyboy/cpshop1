<?php
/**
 * Create Time: 2021/4/2 14:01
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller\wxapp;
use app\store\controller\Base;

class Help extends Base
{
    public function add(){
        if(request()->isAjax()){
            if($result=model('WxappHelp')->add($this->postData('help'))){
                return $this->renderSuccess('添加帮助成功','index');
            }else{
                return $this->renderError('添加帮助失败');
            }
        }
        return $this->fetch('add');
    }


    public function index(){
        $list=model('WxappHelp')->paginate(5);
        return $this->fetch('index',compact('list'));
    }


    public function edit($help_id){
        $model=model('WxappHelp')->detail($help_id);
        if(!request()->isAjax()){
            return $this->fetch('edit',compact('model'));
        }
        $result=$model->edit($this->postData('help'));
        if($result){
            return $this->renderSuccess('更新成功',url('wxapp.help/index'));
        }else{
            return $this->renderError('更新失败');
        }
    }


    public function delete($help_id){
        $result=model('WxappHelp')->find($help_id)->delete();
        if($result){
            return $this->renderSuccess('删除成功');
        }else{
            return $this->renderError('删除失败');
        }
    }
}