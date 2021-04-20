<?php
/**
 * Create Time: 2021/4/2 13:37
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\WxappNavbar as WxappNavbarModel;

class WxappNavbar extends WxappNavbarModel
{
    public function tabbar($data){
        // 删除wxapp缓存
        Wxapp::deleteCache();
        return $this->save($data) !== false;
    }

    /**
     * 小程序导航栏详情
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([]);
    }
}