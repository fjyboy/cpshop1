<?php
/**
 * Create Time: 2021/3/30 15:30
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;
use app\common\exception\BaseException;
use think\Cache;
use think\Model;

class Wxapp extends Base
{

    /**
     * 小程序导航
     * @return \think\model\relation\HasOne
     */
    public function navbar()
    {
        return $this->hasOne('WxappNavbar');
    }

    /**
     * 获取小程序信息
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([], ['serviceImage', 'phoneImage']);
    }

    /**
     * 从缓存中获取小程序信息
     * @param null $wxapp_id
     * @return Wxapp|false|mixed|null
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public static function getWxappCache($wxapp_id = null)
    {
        if (is_null($wxapp_id)) {
            $self = new static();
            $wxapp_id = $self::$wxapp_id;
        }
        if (!$data = Cache::get('wxapp_' . $wxapp_id)) {
            $data = self::get($wxapp_id, ['serviceImage', 'phoneImage', 'navbar']);
            if (empty($data)) throw new BaseException(['msg' => '未找到当前小程序信息']);
            Cache::set('wxapp_' . $wxapp_id, $data);
        }
        return $data;
    }
}