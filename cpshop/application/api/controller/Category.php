<?php
/**
 * Create Time: 2021/4/10 15:46
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller;
use app\api\model\Category as CategoryModel;
use app\api\model\Goods as GoodsModel;

class Category extends Base{
    public function index(){
        // 分类列表
        $categoryList = array_values(CategoryModel::getCacheTree());
        // 商品列表
        $goodsList = (new GoodsModel)->getList($this->request->param());
        return $this->renderSuccess(compact('categoryList', 'goodsList'));
    }

    public function lists(){
        $list = array_values(CategoryModel::getCacheTree());
        return $this->renderSuccess(compact('list'));
    }
}