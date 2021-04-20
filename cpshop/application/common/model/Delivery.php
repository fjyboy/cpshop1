<?php
/**
 * Create Time: 2021/3/31 13:41
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


use app\api\model\Setting;
use think\Model;

class Delivery extends Base
{

    /**
     * 关联配送模板区域及运费
     * @return \think\model\relation\HasMany
     */
    public function rule(){
        return $this->hasMany('DeliveryRule');
    }
    /**
     * 根据运费组合策略 计算最终运费
     * @param $allExpressPrice
     * @return float|int|mixed
     */
    public static function freightRule($allExpressPrice)
    {
        $freight_rule = Setting::getItem('trade')['freight_rule'];
        $expressPrice = 0.00;
        switch ($freight_rule) {
            case '10':    // 叠加
                $expressPrice = array_sum($allExpressPrice);
                break;
            case '20':    // 以最低运费结算
                $expressPrice = min($allExpressPrice);
                break;
            case '30':    // 以最高运费结算
                $expressPrice = max($allExpressPrice);
                break;
        }
        return $expressPrice;
    }

    /**
     * 获取全部
     * @return mixed
     */
    public static function getAll()
    {
        $model = new static;
        return $model->order(['sort' => 'asc'])->select();
    }



    public function getMethodAttr($value){
        $status = [10 => '按件数', 20 => '按重量'];
        return ['text' => $status[$value], 'value' => $value];
    }

    public static function detail($delivery_id)
    {
        return self::get($delivery_id, ['rule']);
    }

    /**
     * 计算配送费用
     * @param $total_num
     * @param $total_weight
     * @param $city_id
     * @return float|int|mixed
     */
    public function calcTotalFee($total_num, $total_weight, $city_id)
    {
        $rule = [];  // 当前规则
        foreach ($this['rule'] as $item) {
            if (in_array($city_id, $item['region_data'])) {
                $rule = $item;
                break;
            }
        }
        // 商品总数量or总重量
        $total = $this['method']['value'] == 10 ? $total_num : $total_weight;
        if ($total <= $rule['first']) {
            return number_format($rule['first_fee'], 2);
        }
        // 续件or续重 数量
        $additional = $total - $rule['first'];
        if ($additional <= $rule['additional']) {
            return number_format($rule['first_fee'] + $rule['additional_fee'], 2);
        }
        // 计算续重/件金额
        if ($rule['additional'] < 1) {
            // 配送规则中续件为0
            $additionalFee = 0.00;
        } else {
            $additionalFee = bcdiv($rule['additional_fee'], $rule['additional'], 2) * $additional;
        }
        return number_format($rule['first_fee'] + $additionalFee, 2);
    }

}