<?php
// [ 后台应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//定义自定义的配置目录
//define('CONF_PATH', __DIR__ . '/../adminconfig/');
define('CONF_PATH', __DIR__ . '/../config/');


//关闭opcache缓存模块
ini_set('opcache.revalidate_freq',0);

//绑定admin模块
define('BIND_MODULE','admin');

// 加载框架引导文件
//require __DIR__ . '/../thinkphp/start.php';

//关闭admin模块下的路由,必须写在框架基础文件之后,执行之前
/*要关闭路由必须改写框架引导文件
改为：
加载框架基础文件
require __DIR__ . '/../thinkphp/base.php'; 

...code
要执行的代码

\think\App::run()->send();执行应用
*/

require __DIR__ . '/../thinkphp/base.php';// 加载框架基础文件

\think\App::route(false);//关闭路由

\think\App::run()->send();// 执行应用

