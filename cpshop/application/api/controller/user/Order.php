<?php
/**
 * Create Time: 2021/4/10 13:31
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller\user;
use app\api\controller\Base;
use app\api\model\Order as OrderModel;
use app\api\model\Wxapp as WxappModel;
use app\common\library\wechat\WxPay;
class Order extends Base
{
    /* @var \app\api\model\User $user */
    private $user;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();   // 用户信息
    }

    public function lists($dataType){
        $model=new OrderModel;
        $list = $model->getList($this->user['user_id'], $dataType);
        return $this->renderSuccess(compact('list'));
    }
    public function receipt($order_id){
        $model=OrderModel::getUserOrderDetail($order_id,$this->user['user_id']);
        if($model->receipt($order_id)){
            return $this->renderSuccess([],'收货成功');
        }
        return $this->renderError('收货失败');
    }

    public function cancel($order_id){
        $model=OrderModel::getUserOrderDetail($order_id,$this->user['user_id']);
        if ($model->cancel($order_id)){
            return $this->renderSuccess([],'取消订单成功');
        }
        return $this->renderError('取消订单失败');
    }


    public function detail($order_id){
        $order = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        return $this->renderSuccess(['order' => $order]);
    }

    public function pay($order_id){
        // 订单详情
        $order = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        // 判断商品状态、库存
        if (!$order->checkGoodsStatusFromOrder($order['goods'])) {
            return $this->renderError($order->getError());
        }
        // 发起微信支付
        $wxConfig = WxappModel::getWxappCache();
        $WxPay = new WxPay($wxConfig);
        $wxParams = $WxPay->unifiedorder($order['order_no'], $this->user['open_id'], $order['pay_price']);
        return $this->renderSuccess($wxParams);
    }
}