<?php
/**
 * Create Time: 2021/4/1 14:54
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


use think\Model;

class StoreUser extends Base
{
    /**
     * 关联微信小程序表
     * @return \think\model\relation\BelongsTo
     */
    public function wxapp() {
        return $this->belongsTo('Wxapp');
    }
}