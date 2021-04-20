<?php
/**
 * Create Time: 2021/4/12 11:55
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\model;
use app\common\model\Delivery as DeliveryModel;
class Delivery extends DeliveryModel
{
    /**
     * 验证用户收货地址是否存在运费规则中
     * @param $city_id
     * @return bool
     */
    public function checkAddress($city_id)
    {
        $cityIds = explode(',', implode(',', array_column($this['rule']->toArray(), 'region')));
        return in_array($city_id, $cityIds);
    }
}