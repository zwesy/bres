<?php

//引入系统路由类
use think\Route;
use think\Request;
use think\Config;


//Route::rule('login/:account/:password','index/User/login', 'POST|GET',['ext'=>'shtml'],['account'=>'^[A-Za-z0-9]\w{4,20}','password'=>'\w{8,20}']);


$module     = config('default_module');
$controller = config('default_controller');
$action     = config('default_action');
//获取path
$path = strtolower(Request::instance()->path());
//拆分获取分组名
$name = explode(Config::get('pathinfo_depr'),$path)[0];

/*last route
return [


];

*/

//+----------------------------------route test -------------------------------+
//由于检测机制问题，动态注册的性能比路由配置要高一些，尤其是多种请求类型混合定义的时候。


return [
	'login/:account/:password'	  => ['index/User/login',['method'=>'psot|get'],['account'=>'^[A-Za-z0-9]\w{4,20}','password'=>'\w{8,20}']],
	'test'						  => ['index/User/test?app_id=1.5&version=2.0',['method'=>'psot|get'],[]],
	//重定向路由,路由到指定文件，可做301跳转(网站迁移)
    'refresh'					  => 'http://www.myloc.loc',
    //利用公共函数文件common.php的回调函数来进行路由验证
    'login'					  	  => ['index/User/login',['method'=>'psot|get','callback'=>'check_login']],
    'unittest'					  => ['index/Index/unitTest',['method'=>'get']],
    'showconfig'				  => ['index/Index/showConfig',['method'=>'get']],
	'/'                           => $module . '/' . $controller . '/' . $action,
    //':module/:controller/:action' => ':module/:controller/:action',
    //':module/:controller'         => ':module/:controller/' . $action,
    //':module'                     => ':module/' . $controller . '/' . $action,
    '__miss__'                    => 'error/Miss/unfound',
    //miss路由也可以直接指向miss文件的完整路径
];



/*域名路由
Route::domain('ip地址或域名','指定模块');
'url_domain_deploy' =>  true
当然也可配置域名后缀
'url_domain_root'=>'bres.com'
Route::domain('m','mobile')对应 m.bres.com 二级域名绑定到mobile模块

Route::domain('m.bres.com',function(){
	Route::rule([
		'index'				=> 'mobile/Index/index',
		'login/:license/:password'    => ['mobile/User/login',['ext'=>'shtml'],
			['license'=>'\d{11}','password'=>'\w{6,20}']
		],

	],'','GET',['ext'=>'html'],['id'=>'\d+']);
});

*/

//Route::miss('./404.html');

/*
* 语法：
*
* 动态方法
* Route::rule('路由规则', '路由地址', '请求类型', '[路由参数]', '[变量规则]');
*
* 批量注册
* Route::rule([
	'路由规则1'=>'路由地址和参数',
	'路由规则2'=>['路由地址和参数','匹配参数（数组）','变量规则（数组）']
	...
	],'','请求类型','匹配参数（数组）','变量规则');
*
* 配置数组（配置文件方式）
* return [
	'路由规则' => '路由地址',
	
	'路由规则' => ['路由地址',[路由参数],[变量规则]]
* ]
*
*/