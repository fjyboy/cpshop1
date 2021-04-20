<?php
/**
 * Create Time: 2021/3/30 14:03
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\Category as CategoryModel;
use think\Cache;

class Category extends CategoryModel
{



    /*
     * 更新记录
     * */
    public function edit($data){
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }

    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        /*if (!isset($data['image']) || empty($data['image'])) {
            $this->error = '请上传分类图片';
            return false;
        }*/
        $data['wxapp_id'] = self::$wxapp_id;
        if (!empty($data['image'])) {
            $data['image_id'] = UploadFile::getFildIdByName($data['image']);
        }
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }
    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        return Cache::rm('category_' . self::$wxapp_id);
    }
}