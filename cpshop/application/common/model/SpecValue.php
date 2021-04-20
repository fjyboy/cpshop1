<?php
/**
 * Create Time: 2021/4/8 13:48
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


class SpecValue extends Base
{
    public function spec(){
        return $this->belongsTo('Spec');
    }
}