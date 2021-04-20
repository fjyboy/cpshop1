<?php
/**
 * Create Time: 2021/4/10 13:42
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\model;
use app\common\model\Goods as GoodsModel;

class Goods extends GoodsModel
{
    /**
     * 获取商品列表
     * @param $param
     * @return mixed
     * @throws \think\exception\DbException
     */


    public function getContentAttr($value)
    {
        return htmlspecialchars_decode($value);
    }

    public function getList($param)
    {
        // 获取商品列表
        $data = parent::getList($param);
        // 隐藏api属性
        !$data->isEmpty() && $data->hidden(['category', 'content', 'spec']);
        // 整理列表数据并返回
        return $data;
    }

    /**根据IdC查找商品
     * @param $goods_id
     * @return bool|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListByIds($goods_id){
        return $this->with(['category', 'image.file', 'spec', 'spec_rel.spec', 'delivery.rule'])
            ->where('goods_id','in',$goods_id)->select();

    }
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