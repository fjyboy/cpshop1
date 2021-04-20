<?php
namespace app\store\controller;
use think\Config;
use think\Controller;
use think\Session;
use app\common\model\Setting;
class Base extends Controller
{
    /* @var array $storeUser 商家登录信息 */
    protected $storeUser;

    /*@var string $route 当前控制器名*/
    protected $controller='';

    /*@var string $route  当前方法名*/
    protected $action='';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 当前路由：分组名称 */
    protected $group = '';

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'login/login',
    ];

    protected $allowAllAction=[
        'login/login',
    ];


    /*初始化*/
    public function _initialize(){

        //获取Session存储的登录信息
        $this->storeUser=Session::get('storeUser');
        // 当前路由信息
        $this->getRouteinfo();
        //判断登录
        $this->checkLogin();
        //加载layout
        $this->layout();
    }


    /*layout布局加载*/
    private function layout(){
        if(!in_array($this->routeUri,$this->notLayoutAction)){


        $this->assign([
            'store_url' => url('/store'),              // 后台模块url
            'base_url' => base_url(),                      // 当前域名
            'menus'=>$this->menus(),
            'group'=>$this->group,
            'storeUser'=>$this->storeUser,
            'setting' => Setting::getAll() ?: null,        // 当前商城设置
        ]);
        }
    }

    private function menus(){
        $data=Config::get('menus');
        foreach ($data as $group=>$first){
            $data[$group]['active']=$group===$this->group;
            //遍历二级菜单
            if(isset($first['submenu'])){
                foreach ($first['submenu'] as $secondKey =>$second){
                    // 二级菜单所有uri
                    $secondUris=[];
                    if(isset($second['submenu'])){
                        // 遍历：三级菜单
                        foreach ($second['submenu']as $thirdKey=>$third){
                            $thirdUris=[];
                            if(isset($third['uris'])){
                                $secondUris=array_merge($secondUris,$third['uris']);
                                $thirdUris=array_merge($thirdUris,$third['uris']);
                            }else{
                                $secondUris[] = $third['index'];
                                $thirdUris[] = $third['index'];
                            }
                            $data[$group]['submenu'][$secondKey]['submenu'][$thirdKey]['active'] = in_array($this->routeUri, $thirdUris);
                        }
                    }else{
                        if (isset($second['uris']))
                            $secondUris = array_merge($secondUris, $second['uris']);
                        else
                            $secondUris[] = $second['index'];
                    }
                    // 二级菜单：active
                    !isset($data[$group]['submenu'][$secondKey]['active'])
                    && $data[$group]['submenu'][$secondKey]['active'] = in_array($this->routeUri, $secondUris);
                }
            }
        }
        return $data;
    }

    /*登录验证*/
    private function checkLogin(){

        if(in_array($this->routeUri, $this->allowAllAction)){
            return true;
        }
        if(empty($this->storeUser) || (int)$this->storeUser['is_login'] !== 1
        ){
            $this->redirect(url('login/login'));
            return false;
        }
        return true;
    }
    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = []){
        return compact('code','msg','url','data');
    }


    /**
     * 返回操作成功时json
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg ='success', $url = '', $data = []){
        return $this->renderJson(1,$msg,$url,$data);
    }

    /**
     * 返回操作失败时json
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
     protected function renderError($msg='error',$url='',$data=[]){
         return $this->renderJson(0,$msg,$url,$data);
     }


    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    /*
        $request = Request::instance();
        echo "当前模块名称是" . $request->module();
        echo "当前控制器名称是" . $request->controller();
        echo "当前操作名称是" . $request->action();
     * */
    protected function getRouteinfo()
    {


        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);

        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;

    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxappId()
    {
        return $this->storeUser['wxapp']['wxapp_id'];
    }
}