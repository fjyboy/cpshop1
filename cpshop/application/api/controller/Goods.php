<?php
/**
 * Create Time: 2021/4/12 11:58
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller;
use app\api\model\Goods as GoodsModel;

class Goods extends Base
{
    public function lists()
    {
        // 整理请求的参数
        $param = array_merge($this->request->param(), [
            'status' => 10
        ]);
        // 获取列表数据

        $list = GoodsModel::getList($param);
        return $this->renderSuccess(compact('list'));
    }


    public function detail($goods_id){


         $detail=GoodsModel::detail($goods_id);
         if (!$detail || $detail['goods_status']['value'] != 10) {
             return $this->renderError('很抱歉，商品信息不存在或已下架');
         }
         $specData = $detail['spec_type'] == 20 ? $detail->getManySpecData($detail['spec_rel'], $detail['spec']) : null;

         return $this->renderSuccess(compact('detail', /*'cart_total_num',*/
            'specData'));
    }

    public function add(){

    }
}