<?php
/**
 * Create Time: 2021/3/30 14:21
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;


use app\common\model\Order as OrderModel;
use think\Request;

class Order extends OrderModel
{
    /**
     * 订单列表
     * @param $filter
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($filter)
    {
        return $this
            ->where($filter)
            ->order(['create_time' => 'desc'])->paginate(10, false, [
                'query' => Request::instance()->request()
            ]);
    }
    public function delivery($data){
        if ($this['pay_status']['value'] == 10
            || $this['delivery_status']['value'] == 20) {
            $this->error = '该订单不合法';
            return false;
        }
        return $this->save([
            'express_company' => $data['express_company'],
            'express_no' => $data['express_no'],
            'delivery_status' => 20,
            'delivery_time' => time(),
        ]);
    }

}