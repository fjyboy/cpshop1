<?php
/**
 * Create Time: 2021/4/10 9:13
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\api\controller;
use app\api\model\User as UserModel;
use app\common\exception\BaseException;

/**
 * Class User
 */
class User extends Base
{

    public function login(){
        $model=new UserModel;
        $user_id=$model->login(request()->post());
        $token=$model->getToken();
        return $this->renderSuccess(compact('user_id', 'token'));
    }
}