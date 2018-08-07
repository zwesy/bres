<?php
/**
* index module  index 
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\index\controller
* @date 2018.07.26 17:00
*/
namespace app\index\controller;
header("Content-type: text/html; charset=utf-8");

use think\Controller;
use think\Session;
use think\Config;
use think\Request;

//引入非框架的类【PHP内置类和自定义类】需要在最前加上反斜杠'\'
use \app\index\model\Products;


/*允许跨域请求*/
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');


class Index extends Controller
{

	private $userInfo = array(); 
	//网站图片服务器地址
	private $image_site_main;
	//主页每页数据的大小
	private static $index_page_size =40;

	public function _initialize()
	{
		$cookie_userinfo = cookie('user');
		$session_userinfo = Session::get('user');
		if (isset($cookie_userinfo)) {
			$this->userInfo = $cookie_userinfo;
		} elseif (isset($session_userinfo)) {
			$this->userInfo = $session_userinfo;
		}
		$this->image_site_main = Config::get('myconfig.image_site_main');
	}

    public function index()
    {
	    $user_data = array();
        if (count($this->userInfo) !== 0) {
       		$user_data = $this->userInfo;
        }
        $Products = new Products();
        $result = $Products->getproducts(0, 1, Index::$index_page_size);

        //绑定数据到视图
        $this->assign([
        	'site_name' => '主页--欢迎来到BRES',
	        'user_data' => $user_data,
	        'main_data' => $result,
	        'image_site' => $this->image_site_main,
	        'empty' => '<span class="empty">(。・＿・。)ﾉ sorry~，数据不存在~</span>',
        ]);

       //return $this -> fetch('./template/index/index.html'); 跳转到指定模板
       return $this -> fetch('index/index');
    }

    /**
     * 主页翻页数据获取
     * @access public
     * @return [json]      返回的数据集
     */
    public function indexPage(Request $request)
    {
    	$arr_param = $request->param();

    	$page = $arr_param['page'];

    	$Products = new Products();
        $result = $Products->getproducts(0, $page, Index::$index_page_size);
        //不转义中文汉字的方法,ios程序中不识别读取到的JSON数据中 \u开头的数据
        //return json_encode($result,JSON_UNESCAPED_UNICODE);
        /*json_encode()与tp封装的json()方法返回的数据类型有所差异
		json_encode()返回的是json数组格式，前端需要用$.parseJSON()进行转义为json对象处理
		而json()直接返回的是json对象
        */
        return json($result);//注意传入参数格式，不然会出现500错误
    }
    

    //+------------------------------------------------------------------+
    /**
     * [动态添加配置项,零时性的]
     * @author zwesy
     * @date   2018-07-30T04:48:45+0800
     * @return [mixed]
     */
    public function customConfigs()
    {
    	//设置一组配置项
    	$config = [
    		'user_enable_register' => 'off',
    		'user_enable_login' => 'off',
    	];
    	//批量设置，写入user作用域
    	//作用域在全部配置项中相当于二级配置项的名称
    	Config::set($config, 'myconfig');
    	Config::range('_sys_');
    	dump(Config::get());
    }

    /**
     * [方法注入]
     * @author zwesy
     * @access public
     * @param  integer
     * @return [json]
     */
    public function funczr($uid =1)
    {
    	//动态方法注入,getUserInfo定义于公共函数文件userfunc.php
    	//user 相当于方法getUserInfo的别名
		Request::hook('user','getUserInfo');
		
		$request = Request::instance();//实例化对象
		$info = $request->user($uid);
		return json($info);
    }

    /**
     * [查看配置参数]
     * @author zwesy
     * @date   2018-07-30T06:49:29+0800
     * @return [type]
     */
    public function showConfig()
    {	//切换作用域,切换到系统作用域
    	Config::range('_sys_');
    	//打印配置文件配置项
		dump(\think\Config::get());
    }

    /**
    * 单元测试
    */
    public function unitTest()
    {
    	//dump($_SERVER);
    	//dump(ROOT_PATH);
    	//$this->view->engine->layout(true);
    	$this->assign([
    		'site_name'	=> 'unitTest--BRES',
    	]);

    	return $this->fetch('/admin/main');
    }
    
    /**
    * 测试
    */
    public function test()
    {
    	$method =  get_class_methods('\think\Request');
    	dump($method);
    }
}
