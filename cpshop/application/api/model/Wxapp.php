<?php
/**
 * Create Time: 2021/4/10 9:42
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\api\model;
use app\common\model\Wxapp as WxappModel;

class Wxapp extends WxappModel
{
    /**
     * 在线客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function serviceImage()
    {
        return $this->belongsTo('uploadFile', 'service_image_id');
    }

    /**
     * 电话客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function phoneImage()
    {
        return $this->belongsTo('uploadFile', 'phone_image_id');
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