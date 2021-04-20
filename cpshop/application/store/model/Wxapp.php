<?php
/**
 * Create Time: 2021/3/30 15:29
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\Wxapp as WxappModel;
use think\Cache;
class Wxapp extends WxappModel
{
    /**
     * 删除wxapp缓存
     * @return bool
     */
    public static function deleteCache()
    {
        return Cache::rm('wxapp_' . self::$wxapp_id);
    }

    public function edit($data){
        self::deleteCache();
        return $this->allowField(true)->save($data) !== false;

    }
}