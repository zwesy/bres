<?php
/**
 * 分组路由文件
 * route group  虚拟分组
 * 在配置文件中定义路由配置文件（数组）
 * 'route_config_file' =>  ['route', 'routegroup']
 * @author zwesy <zwesy@qq.com>
 * @date 2018-07-31 14:11
 */

//引入系统路由类
use think\Route;
use think\Request;
use think\Config;


$module     = config('default_module');
$controller = config('default_controller');
$action     = config('default_action');
//获取path
$path = strtolower(Request::instance()->path());
//拆分获取分组名
$name = explode(Config::get('pathinfo_depr'),$path)[0];


//+------------------------last test -----------------------------+
//分组1，get 请求
Route::group('index',
	[
		'[:s]'		=> ['index',['ext'=>'html']],
		':a'  		=> ['test'],
		':b'  		=> ['UnitTest',['ext'=>'shtml']],
		':c'  		=> ['showConfig'],//避免出现无法匹配的情况请加上[]
		':d'  		=> ['funczr'],
	],[
		'method' 	=> 'get',
		'prefix' 	=> 'index/Index/'
	],[
		's' 		=> '(index)?',
		'a' 		=> 'test',
		'b' 		=> 'utest',
		'c' 		=> 'sc',
		'd' 		=> 'ffzr'
	]
);
//分组2，post 请求
Route::group('index',
	[
		':a'		=> ['indexPage'],
	],[
		'method' 	=> 'get|post',
		'prefix' 	=> 'index/Index/'
	],[
		'a' 		=> 'page',
	]
);

//+------------------------route test -----------------------------+
//由于检测机制问题，动态注册的性能比路由配置要高一些，尤其是多种请求类型混合定义的时候。
//闭包方式
/*Route::group('index/testgrp',function(){
	Route::get(':a','index/Index/test',[],['a'=>'\d{1}']);
	Route::get([
		':b' => ['index/Index/UnitTest',['ext'=>'shtml'],['b'=>'\d{2}']],
		':c' => ['index/Index/showConfig',[],['c'=>'\d{3}']],
	]);
});*/
//动态注册,优化后方案参考分组1
/*Route::group(['name'=>'index/testgrp','method'=>'get','prefix'=>'index/Index/'],[
	':a'=>['test',[],['a'=>'\d{1}']],
	':b'=>['UnitTest',['ext'=>'shtml'],['b'=>'\d{2}']],
	':c'=>['showConfig',[],[ 'c'=>'\d{3}']],
]);*/




//路由配置
/*return [
	'index/testgrp/:a'=>['index/Index/test',['method'=>'get'],['a'=>'\d{1}']],
	'index/testgrp/:b'=>['index/Index/UnitTest',['method'=>'get'],['b'=>'\d{2}']],
	'index/testgrp/:c'=>['index/Index/showConfig',['method'=>'get'],['c'=>'\d{3}']],
];*/

/*return [
	'[index/testgrp]'=>[
	':a'=>['index/Index/test',['method'=>'get'],['a'=>'\d{1}']],
	':b'=>['index/Index/UnitTest',['method'=>'get'],['b'=>'\d{2}']],
	':c'=>['index/Index/showConfig',['method'=>'get'],['c'=>'\d{3}']],
	],
];*/