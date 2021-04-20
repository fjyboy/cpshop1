<?php
/**
 * Create Time: 2021/3/30 10:12
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller;
use app\store\model\Goods as GoodsModel;
use app\store\model\Delivery ;
use app\store\model\Category ;


class Goods extends Base
{

    public function index(){
        //获取所有商品列表
        $model=model('Goods');
        $list = $model->getList(array_merge(['status' => -1], $this->request->param()));
        return $this->fetch('index',compact('list'));
    }


    /*
     * 添加
     * */
    public function add(){
        if(request()->isAjax()){
            $model=new GoodsModel;
            if($model->add($this->postData('goods'))){
                return $this->renderSuccess('商品添加成功','index');
            }
            return $this->renderError($model->getError()?:'商品添加失败');
        }
        $delivery=Delivery::getAll();
        $catgory=model('Category')->getCacheTree();
        return $this->fetch('add',compact('delivery','catgory'));

    }

    public function delete($goods_id){
        $model = GoodsModel::get($goods_id);
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    public function edit($goods_id){
        // 商品详情
        $model = GoodsModel::detail($goods_id);
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = Category::getCacheTree();
            // 配送模板
            $delivery = Delivery::getAll();
            // 多规格信息
            $specData = 'null';
            if ($model['spec_type'] == 20)
                $specData = json_encode($model->getManySpecData($model['spec_rel'], $model['spec']));
            return $this->fetch('edit', compact('model', 'catgory', 'delivery', 'specData'));
        }
        // 更新记录 
        if ($model->edit($this->postData('goods'))) {
            return $this->renderSuccess('更新成功', url('goods/index'));
        }
        $error = $model->getError() ?: '更新失败';
        return $this->renderError($error);
    }
}