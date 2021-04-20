<?php
/**
 * Create Time: 2021/3/29 14:42
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\store\controller;


use think\Session;

class Login extends Base
{
    public function login(){
        if(request()->isAjax()){
            $data=[
                'user_name'=>input('post.user_name'),
                'password'=>input('post.password')
            ];
            $model=model('StoreUser');
            $result=$model->login($data);
            if($result){
                return $this->renderSuccess('登录成功',url('store/index/index'));
            }else{
                return $this->renderError($model->getError()?:'登录失败');
            }
        }

        $this->view->engine->layout(false);
        return $this->fetch('index');
    }

    public function loginout(){
        Session::clear('storeUser');
        $this->redirect('store/login/login');
    }
}