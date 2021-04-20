<?php
/**
 * Create Time: 2021/4/2 14:04
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


class WxappHelp extends Base
{
    protected $name = 'wxapp_help';

    /**
     * 帮助详情
     * @param $help_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($help_id)
    {
        return self::get($help_id);
    }


    /**
     * 获取帮助列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->order(['sort' => 'asc'])->select();
    }
}