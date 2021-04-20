<?php
/**
 * Create Time: 2021/3/31 10:07
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\store\controller\setting;
use app\store\controller\Base;
use think\Cache as Driver;
class Cache extends Base
{
    public function clear($isForce = false){
        if ($this->request->isAjax()) {
            $data = $this->postData('cache');
            $this->rmCache($data['keys'], isset($data['isForce']) ? !!$data['isForce'] : false);
            return $this->renderSuccess('操作成功');
        }
        return $this->fetch('clear',[
            'cacheList'=>$this->getCacheKeys(),
            'isForce'=>!!$isForce?:config('app_debug'),
        ]);
    }
    /**
     * 删除缓存
     * @param $keys
     * @param bool $isForce
     */
    private function rmCache($keys, $isForce = false)
    {
        if ($isForce === true) {
            Driver::clear();
        } else {
            $cacheList = $this->getCacheKeys();
            foreach (array_intersect(array_keys($cacheList), $keys) as $key) {
                Driver::has($cacheList[$key]['key']) && Driver::rm($cacheList[$key]['key']);
            }
        }
    }
    /**
     * 获取缓存索引数据
     */
    private function getCacheKeys()
    {
        $wxapp_id = self::getWxappId();
        return [
            'setting' => [
                'key' => 'setting_' . $wxapp_id,
                'name' => '商城设置'
            ],
            'category' => [
                'key' => 'category_' . $wxapp_id,
                'name' => '商品分类'
            ],
            'wxapp' => [
                'key' => 'wxapp_' . $wxapp_id,
                'name' => '小程序设置'
            ],
        ];
    }

}