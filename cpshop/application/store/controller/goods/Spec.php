<?php
/**
 * Create Time: 2021/4/9 15:06
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */

namespace app\store\controller\goods;
use app\store\controller\Base;
use app\store\model\Spec as SpecModel;
use app\store\model\SpecValue as SpecValueModel;

class Spec extends Base
{
    /* @var SpecModel $SpecModel */
    private $SpecModel;

    /* @var SpecValueModel $SpecModel */
    private $SpecValueModel;

    /**
     * 构造方法
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->SpecModel = new SpecModel;
        $this->SpecValueModel = new SpecValueModel;
    }

    public function addSpec($spec_name, $spec_value){
        // 判断规格组是否存在
        if (!$specId = $this->SpecModel->getSpecIdByName($spec_name)) {
            // 新增规格组and规则值
            if ($this->SpecModel->add($spec_name)
                && $this->SpecValueModel->add($this->SpecModel['spec_id'], $spec_value))
                return $this->renderSuccess('', '', [
                    'spec_id' => (int)$this->SpecModel['spec_id'],
                    'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
                ]);
            return $this->renderError();
        }
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($specId, $spec_value)) {
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($specId, $spec_value))
            return $this->renderSuccess('', '', [
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
            ]);
        return $this->renderError();
    }

    public function addSpecValue($spec_id, $spec_value){
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($spec_id, $spec_value)) {
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($spec_id, $spec_value))
            return $this->renderSuccess('', '', [
                'spec_value_id' => (int)$this->SpecValueModel['spec_value_id'],
            ]);
        return $this->renderError();
    }
}