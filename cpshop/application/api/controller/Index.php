<?php
/**
 * Create Time: 2021/4/10 15:37
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\WxappPage;

class Index extends Base
{
    public function page(){
        // 页面元素
        $wxappPage = WxappPage::detail();
        $items = $wxappPage['page_data']['array']['items'];
        // 新品推荐
        $model = new GoodsModel;
        $newest = $model->getNewList();
        // 猜您喜欢
        $best = $model->getBestList();
        return $this->renderSuccess(compact('items', 'newest', 'best'));
    }
}