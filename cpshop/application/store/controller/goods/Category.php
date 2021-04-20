<?php
/**
 * Create Time: 2021/3/30 13:47
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller\goods;
use app\store\controller\Base;
use app\store\model\Category as CategoryModel;

class Category extends Base
{
    public function index(){
        $model=model('Category');
        $list=$model->select();

        return $this->fetch('index',compact('list'));
    }

    public function delete($category_id){
        $Category=model('Category')->find($category_id)->delete();

        if($Category){
            return $this->renderSuccess('删除成功');
        }else{
            return $this->renderError('删除失败');
        }
    }

    public function edit($category_id){

        $model = CategoryModel::get($category_id, ['image']);
        if(request()->isAjax()){
            // 更新记录
            if ($model->edit($this->postData('category'))) {
                return $this->renderSuccess('更新成功', url('goods.category/index'));
            }
            $error = $model->getError() ?: '更新失败';
            return $this->renderError($error);
        }

        // 获取所有地区
        $list = $model->getCacheTree();
        $model=model('Category')->with('')->find(input('category_id'));
        $viewData=[
            'model'=>$model
        ];
        $this->assign($viewData);

        return $this->fetch('edit',compact('list'));
    }


    public function add(){
        $model = new CategoryModel;
        if(request()->isAjax()){
            $data=$this->postData('category');
            if($model->add($data)){
                return $this->renderSuccess('添加成功','index');
            }else{
                return $this->renderError('添加失败');
            }
        }
        // 获取所有地区
        $list=$model->getCacheTree();
        return $this->fetch('add',compact('list'));
    }
}