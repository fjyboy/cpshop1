<?php
/**
 * Create Time: 2021/4/6 10:19
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller\setting;
use app\store\controller\Base;
use app\store\model\Region;
use app\store\model\Delivery as DeliveryModel;

class Delivery extends Base
{
    public function index(){
        $list=model('Delivery')->paginate('10');

        return $this->fetch('index',compact('list'));
    }

    public function add(){
        if(!request()->isAjax()){
            // 获取所有地区
            $regionData = json_encode(Region::getCacheTree());
            return $this->fetch('add',compact('regionData'));
        }
        $data=$this->postData('delivery');
        if(model('Delivery')->add($data)){
            return $this->renderSuccess('添加成功','index');
        }else{
            return $this->renderError('添加失败');
        }
    }

    public function edit($delivery_id){
        $model = DeliveryModel::detail($delivery_id);
        if(!request()->isAjax()){
            $regionData = json_encode(Region::getCacheTree());
            return $this->fetch('edit',compact('model','regionData'));
        }
        if($model->edit($this->postData('delivery'))){
            return $this->renderSuccess('提交成功',url('setting.delivery/index'));
        }else{
            return $this->renderError('提交失败');
        }
    }


    public function delete($delivery_id){
        $model=new DeliveryModel;
        $result=$model->where('delivery_id','=',$delivery_id)->delete();
        if($result){
            return $this->renderSuccess('删除成功');
        }else{
            return $this->renderError('删除失败');
        }
    }
}