<?php
/**
 * Create Time: 2021/4/2 11:27
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\model;
use app\common\model\WxappPage as WxappPageModel;

class WxappPage extends WxappPageModel
{
    public function edit($page_data){
        // 删除wxapp缓存
        Wxapp::deleteCache();
        return $this->save(compact('page_data')) !== false;
    }
}