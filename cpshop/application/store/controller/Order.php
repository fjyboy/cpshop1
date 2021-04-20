<?php
/**
 * Create Time: 2021/3/30 14:19
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;
use app\store\model\Order as OrderModel;
use think\Hook;

class Order extends Base
{


    //待发货订单列表
    public function delivery_list(){
        return $this->getList('待发货订单列表', [
            'pay_status' => 20,
            'delivery_status' => 10
        ]);
    }
    //待收货订单列表
    public function receipt_list(){
        return $this->getList('待收货订单列表', [
            'pay_status' => 20,
            'delivery_status' => 20
        ]);
    }
    //待付款订单列表
    public function pay_list(){
        return $this->getList('待付款订单列表', [
            'pay_status' => 10,
            'delivery_status' => 10
        ]);
    }
    /**
     * 已完成订单列表
     * @return mixed
     * @throws \think\exception\DbException
     **/
    public function complete_list(){
        return $this->getList('已完成订单列表',[
            'order_status'=>30
        ]);
    }
    /**
     * 已取消订单列表
     * @return mixed
     * @throws \think\exception\DbException
     **/
    public function cancel_list(){
        return $this->getList('已取消订单列表',[
            'order_status'=>30
        ]);
    }
    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     **/
    public function all_list(){
        return $this->getList('全部订单列表');
    }

    /**
     * 订单列表
     * @param $title
     * @param $filter
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $filter = [])
    {
        $model = new OrderModel;
        $list = $model->getList($filter);
        return $this->fetch('index', compact('title','list'));
    }

    /**
     * 订单详情页面
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     **/
    public function detail($order_id){
        $model=model('Order');
        $detail=$model->detail($order_id);
        if($detail){
            return $this->fetch('detail',compact('detail'));
        }else{
            $this->renderError($model->getError()?: '查看详情失败');
        }
    }


    /**
     * 发货
     * @param $order_id
     * @return array
     * throws \think\exception\DbException
     **/
    public function delivery($order_id){
        $model=model('Order')->detail($order_id);
        if($model->delivery($this->postData('order'))){
            return $this->renderSuccess('发货成功');
        }else{
            return $this->renderError('发货失败');
        }


    }
}