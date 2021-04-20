<?php
/**
 * Create Time: 2021/4/2 9:45
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;




class OrderAddress extends Base
{
    protected $name = 'order_address';
    protected $updateTime = false;

    /**
     * 追加字段
     * @var array
     */
    protected $append = ['region'];

    /**
     * 地区名称
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionAttr($value, $data)
    {
        return [
            'province' => Region::getNameById($data['province_id']),
            'city' => Region::getNameById($data['city_id']),
            'region' => Region::getNameById($data['region_id']),
        ];
    }
}