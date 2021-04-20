<?php
/**
 * Create Time: 2021/3/30 14:23
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


use think\Model;
use think\Hook;

class Order extends Base
{

    /**
     * 订单模型初始化
     */
    public static function init()
    {
        parent::init();
        // 监听订单处理事件
        $static = new static;
        Hook::listen('order', $static);
    }
    /**
     * 生成订单号
     */
    protected function orderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
    /**
     * 订单商品列表
     * @return \think\model\relation\HasMany
     */
    public function goods(){
        return $this->hasMany('OrderGoods');
    }

    /**
     * 用户关联
     * @return \think\model\relation\BelongsTo
     */
    public function user(){
        return $this->belongsTo('User');
    }

    /**
     * 地址关联
     * @return \think\model\relation\HasOne
     */
    public function address(){
        return $this->hasOne('OrderAddress');
    }


    /**
     * 付款状态
     * @param $value
     * @return array
     */
    public function getPayStatusAttr($value)
    {
        $status = [10 => '待付款', 20 => '已付款'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 发货状态
     * @param $value
     * @return array
     */
    public function getDeliveryStatusAttr($value)
    {
        $status = [10 => '待发货', 20 => '已发货'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 收货状态
     * @param $value
     * @return array
     */
    public function getReceiptStatusAttr($value)
    {
        $status = [10 => '待收货', 20 => '已收货'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 收货状态
     * @param $value
     * @return array
     */
    public function getOrderStatusAttr($value)
    {
        $status = [10 => '进行中', 20 => '取消', 30 => '已完成'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 订单详情
     * @param $order_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($order_id)
    {
        return self::get($order_id, ['goods.image', 'address']);
    }
}

