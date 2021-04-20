<?php
/**
 * Create Time: 2021/4/12 15:30
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\model;
use app\common\model\DeliveryRule as DeliveryRuleModel;

class DeliveryRule extends DeliveryRuleModel
{
    /**
     * 追加字段
     * @var array
     */
    protected $append = ['region_data'];

    /**
     * 地区集转为数组格式
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionDataAttr($value, $data)
    {
        return explode(',', $data['region']);
    }

}