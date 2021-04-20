<?php
/**
 * Create Time: 2021/3/29 15:55
 * Author:Liu Jiabing.
 * Email:531288693@qq.com
 */
namespace app\store\model;
use think\Session;
use app\common\model\StoreUser as StoreUserModel;

class StoreUser extends StoreUserModel
{

    public function login($data){
        if(!$user=$this->where([
                'user_name'=>$data['user_name'],
                'password'=>yoshop_hash($data['password'])
            ]
        )->find()){
            $this->error='登录失败, 用户名或密码错误';
            return false;
        }
        Session::set('storeUser',[
            'store_user_id' => $user['store_user_id'],
            'user_name' => $user['user_name'],
            'is_login' => true,
            'wxapp' => $user['wxapp'],
        ]);
        return true;
    }
    /**
     * 商户信息
     * @param $store_user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($store_user_id)
    {
        return self::get($store_user_id);
    }


    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {

        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('storeUser', [
            'store_user_id' => $this['store_user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }
}