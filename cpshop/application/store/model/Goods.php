<?php
/**
 * Create Time: 2021/3/30 10:15
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use think\Db;
use app\common\model\GoodsSpec ;
use app\common\model\Goods as GoodsModel;
use think\Session;

class Goods extends GoodsModel
{

    public function add($data){
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;

        // 开启事务

            // 添加商品
            $this->allowField(true)->save($data)||$this->error = '添加商品失败';
            // 商品规格
            $this->addGoodsSpec($data)||$this->error = '商品规格';
            // 商品图片
            $this->addGoodsImages($data['images'])||$this->error = '商品图片';
            return true;

        }
    /**
     * 删除商品
     * @return bool
     */
    public function remove()
    {
        // 开启事务处理
        Db::startTrans();
        try {
            // 删除商品sku
            (new GoodsSpec)->removeAll($this['goods_id']);
            // 删除商品图片
            $this->image()->delete();
            // 删除当前商品
            $this->delete();
            // 事务提交
            Db::commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Db::rollback();
            return false;
        }
    }
    public function edit($data){

        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;
        // 开启事务
        Db::startTrans();
        try {
            // 保存商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addGoodsSpec($data, true);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            $this->error = $e->getMessage();
            return false;
        }
    }


    /**
     * 添加商品规格
     * @param $data
     * @param $isUpdate
     * @throws \Exception
     */
    private function addGoodsSpec(&$data, $isUpdate = false)
    {
        // 更新模式: 先删除所有规格
        $model = new GoodsSpec;
        $isUpdate && GoodsSpec::removeAll($this['goods_id']);
        // 添加规格数据
        if ($data['spec_type'] == '10') {
            // 单规格
            $this->spec()->save($data['spec']);
        } else if ($data['spec_type'] == '20') {
            // 添加商品与规格关系记录
            $model->addGoodsSpecRel($this['goods_id'], $data['spec_many']['spec_attr']);
            // 添加商品sku
            $model->addSkuList($this['goods_id'], $data['spec_many']['spec_list']);
        }
    }


    /**
     * 添加商品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addGoodsImages($images)
    {
        $this->image()->delete();
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }
}