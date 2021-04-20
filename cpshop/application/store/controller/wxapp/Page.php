<?php
/**
 * Create Time: 2021/3/30 15:35
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\store\controller\wxapp;
use app\store\controller\Base;

class Page extends Base
{
    public function home()
    {
        $model = model('WxappPage')->detail();
        if (!$this->request->isAjax()) {
            $jsonData = $model['page_data']['json'];
            return $this->fetch('home', compact('jsonData'));
        }
        $data = $this->postData('data');
        if (!$model->edit($data)) {
            return $this->renderError('更新失败');
        }
        return $this->renderSuccess('更新成功');
    }

    public function links(){
        
        return $this->fetch('links');
    }
}