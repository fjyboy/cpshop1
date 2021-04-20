<?php
/**
 * Create Time: 2021/3/30 15:27
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;
use think\Request;

class Wxapp extends Base
{
    public function setting(){
        $wxapp=model('Wxapp')->find();
        if(!request()->isAjax()){
            return $this->fetch('setting',compact('wxapp'));
        }
        $result=($wxapp->edit($this->postData('wxapp')));
        if($result){
            return $this->renderSuccess('更新成功');
        }else{
            return $this->renderError('更新失败');
        }
    }

    public function tabbar(){
        $model = model('WxappNavbar')->detail();
        if (!$this->request->isAjax()) {
            return $this->fetch('tabbar', compact('model'));
        }
        $data = $this->postData('tabbar');
        if (!$model->tabbar($data)) {
            return $this->renderError('更新失败');
        }
        return $this->renderSuccess('更新成功');
    }
}