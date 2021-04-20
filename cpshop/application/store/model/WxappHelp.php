<?php
/**
 * Create Time: 2021/4/2 14:04
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\WxappHelp as WxappHelpModel;

class WxappHelp extends WxappHelpModel
{
    public function add($data){
        $data['wxapp_id'] = self::$wxapp_id;
        return $this->allowField(true)->save($data);
    }
    public function edit($data){
        $data['wxapp_id']=self::$wxapp_id;
        return $this->allowField(true)->save($data) !== false;
    }
}