<?php
/**
 * Create Time: 2021/4/9 13:56
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\store\controller\store;
use app\store\controller\Base;
use app\store\model\StoreUser;


class User extends Base
{
    public function renew()
    {
        $model = StoreUser::detail($this->storeUser['store_user_id']);
        if (request()->isAjax()) {
            if ($model->renew($this->postData('user'))) {
                return $this->renderSuccess('修改成功', 'renew');
            } else {
                return $this->renderError('修改失败');
            }
        }
        return $this->fetch('renew', compact('model'));
    }
}