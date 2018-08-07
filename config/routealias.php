<?php
/**
 * route alias 别名路由文件
 * 在配置文件中定义路由配置文件（数组）
 * 'route_config_file' =>  ['route', 'routegroup','routealias']
 * @author zwesy <zwesy@qq.com>
 * @date 2018-07-31 22:30
 */

//引入系统路由类
use think\Route;



/**
 * 别名路由可快速路由到控制器或类
 * 别名路由可设置白名单和黑名单
 * 
 * 别名路由可快速注册同同一控制器下的所有操作方法
 * 别名路由不支持路由规则
 * 路由别名不支持变量规则和路由条件判断，单纯只是为了缩短URL地址，
 * 并且在定义的时候需要注意避免和路由规则产生混淆。
 * 因此路由带判断性的如before_behavior、callback等无法使用
 */

//+-----------------------last route-----------------------+



//+-----------------------test route-----------------------+
//动态注册：Route::alias('规则名称','模块/控制器',['路由参数']);
Route::alias('api','api/V1',
	[
		'ext'=>'html|shtml',
		'allow'=>'toolfunc1,toolfunc3',//白名单
		'except'=>'toolfunc2',//黑名单
    	'method'=>['index'=>'GET','login'=>'POST','register'=>'POST'],//设置操作类型
	]
);
