<?php
/**
 * Create Time: 2021/4/12 9:19
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller;
use app\api\model\Cart as CartModel;

class Cart extends Base
{
    //用户信息
    private $user;
    //购物车信息
    private $model;

    /**
     * 初始化获取当前id信息
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize(){
        parent::_initialize();
        $this->user=$this->getUser();
        $this->model = new CartModel($this->user['user_id']);
    }
    public function sub($goods_id, $goods_sku_id)
    {
        $this->model->sub($goods_id, $goods_sku_id);
        return $this->renderSuccess();
    }
    /**
     * 购物车列表
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists(){
        return $this->renderSuccess($this->model->getList($this->user));
    }

    /**
     * 添加到购物车
     * @param $goods_id
     * @param $goods_num
     * @param $goods_sku_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function add($goods_id,$goods_num,$goods_sku_id){
        if (!$this->model->add($goods_id, $goods_num, $goods_sku_id)) {
            return $this->renderError($this->model->getError() ?: '加入购物车失败');
        }
        $total_num = $this->model->getTotalNum();
        return $this->renderSuccess(['cart_total_num' => $total_num], '加入购物车成功');
    }

    public function delete($goods_id, $goods_sku_id){
        $this->model->delete($goods_id, $goods_sku_id);
        return $this->renderSuccess();
    }

}