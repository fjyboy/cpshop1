<?php
/**
 * Create Time: 2021/3/31 10:36
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\common\model;


use think\Model;

class GoodsImage extends Base
{
    protected $name = 'goods_image';
    protected $updateTime = false;

    /**
     * 关联文件库
     * @return \think\model\relation\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('UploadFile', 'image_id', 'file_id')
            ->bind(['file_path', 'file_name', 'file_url']);
    }


}