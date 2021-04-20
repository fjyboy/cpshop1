<?php
/**
 * Create Time: 2021/4/2 15:10
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\Setting as SettingModel;
use think\Cache;

class Setting extends SettingModel
{
    /**
     * 设置项描述
     * @var array
     */
    private $describe = [
        'sms' => '短信通知',
        'storage' => '上传设置',
        'store' => '商城设置',
        'trade' => '交易设置',
    ];

    /**
     * 更新系统设置
     * @param $key
     * @param $values
     * @return bool
     * @throws \think\exception\DbException
     */
    public function edit($key, $values)
    {
        $model = self::detail($key) ?: $this;
        // 删除系统设置缓存
        Cache::rm('setting_' . self::$wxapp_id);
        return $model->save([
                'key' => $key.'',
                'describe' => $this->describe[$key],
                'values' => $values,
                'wxapp_id' => self::$wxapp_id,
            ]) !== false;
    }

}