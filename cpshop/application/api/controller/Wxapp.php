<?php
/**
 * Create Time: 2021/4/10 14:42
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller;
use app\api\model\Wxapp as WxappModel;
use app\api\model\WxappHelp;
class Wxapp extends Base
{

    public function base(){
        $wxapp = WxappModel::getWxappCache();
        return $this->renderSuccess(compact('wxapp'));
    }
    public function help(){
        $model=new WxappHelp();
        $list=$model->getList();
        return $this->renderSuccess(compact('list'));


    }
}