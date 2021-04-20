<?php
/**
 * Create Time: 2021/4/10 11:07
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\api\controller\user;
use app\api\controller\Base;
use app\api\model\Order as OrderModel;

class Index extends Base
{
    public function detail(){
        // 当前用户信息
        $userInfo = $this->getUser();
        // 订单总数
        $model = new OrderModel;
        $orderCount = [
            'payment' => $model->getCount($userInfo['user_id'], 'payment'),
            'delivery' => $model->getCount($userInfo['user_id'], 'delivery'),
            'received' => $model->getCount($userInfo['user_id'], 'received'),
        ];
        return $this->renderSuccess(compact('userInfo', 'orderCount'));
    }


}