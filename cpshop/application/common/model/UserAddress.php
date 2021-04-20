<?php
/**
 * Create Time: 2021/4/10 11:20
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


class UserAddress extends Base
{
    protected $name = 'user_address';

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

    /**
     * 收货地址详情
     * @param $user_id
     * @param $address_id
     * @return null|\app\api\model\UserAddress
     * @throws \think\exception\DbException
     */

}