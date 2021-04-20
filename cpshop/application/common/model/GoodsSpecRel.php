<?php
/**
 * Create Time: 2021/4/9 15:33
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


class GoodsSpecRel extends Base
{
    protected $name = 'goods_spec_rel';
    protected $updateTime = false;

    /**
     * 关联规格组
     * @return \think\model\relation\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo('Spec');
    }
}