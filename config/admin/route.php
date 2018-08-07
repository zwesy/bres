<?php
//动态绑定模块
/**
 * 实现入口文件绑定到指定模块有3种方法，
 * 方法一： 在入口文件中设置define('BIND_MODULE','模块[/控制器]')
 * 方法二：在配置文件中开启入口文件自动绑定模块选项auto_bind_module=true,注意入口文件名需要与绑定的模块同名,一般不推荐
 * 方法三：路由绑定方式，如下面
 */

/**
 * 路由绑定模块
 * 语法：Route::bind('模块[/控制器[/操作]]')
 * 1、绑定到指定模块
 * Route::bind('模块')
 * 2、绑定到指定模块的控制器
 * Route::bind('模块/控制器')
 * 3、绑定到指定模块的控制器下的某个操作,前提是没有关闭路由
 * Route::bind('模块/控制器/操作')
 * 4、绑定到命名空间或指定的类，前提是没有关闭路由
 * 直接绑定到命名空间或指定类会跳过模块配置文件，因此无法获取到该模块的配置
 */

use think\Route;
/*
绑定到admin模块
Route::bind('admin'); 
绑定到admin模块的Index控制器
Route::bind('admin/Index');
绑定到admin模块的Index控制器中的login操作
Route::bind('admin/Index/login');
*/



//+----------------------------------------------+
//以下2种会导致admin模块下的配置文件失效
//绑定到命名空间
//Route::bind('app\admin\controller','namespace');
//绑定到指定类
//Route::bind('app\admin\controller\Index','class');
