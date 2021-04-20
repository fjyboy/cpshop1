<?php
/**
 * Create Time: 2021/3/30 11:50
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;
use app\store\model\GoodsSpecRel;

class GoodsSpec extends Base
{
    protected $name = 'goods_spec';

    /**
     * 删除规格
     * @param $goods_id
     * @return int
     */
    public function  removeAll($goods_id){
        $model = new GoodsSpecRel;
        $model->where('goods_id','=', $goods_id)->delete();
        return self::where('goods_id','=', $goods_id)->delete();
    }

    /*
     * 添加商品与规格关系记录
     * */
    public function addGoodsSpecRel($goods_id,$spec_attr){
        $data = [];
        array_map(function ($val) use (&$data, $goods_id) {
            array_map(function ($item) use (&$val, &$data, $goods_id) {
                $data[] = [
                    'goods_id' => $goods_id,
                    'spec_id' => $val['group_id'],
                    'spec_value_id' => $item['item_id'],
                    'wxapp_id' => self::$wxapp_id,
                ];
            }, $val['spec_items']);
        }, $spec_attr);
        $model = new GoodsSpecRel;
        return $model->saveAll($data);
    }
    /*
     * 添加商品sku
     * */
    public function addSkuList($goods_id,$spec_list){
        $data = [];
        foreach ($spec_list as $item) {
            $data[] = array_merge($item['form'], [
                'spec_sku_id' => $item['spec_sku_id'],
                'goods_id' => $goods_id,
                'wxapp_id' => self::$wxapp_id,
            ]);
        }
        return $this->saveAll($data);
    }
}