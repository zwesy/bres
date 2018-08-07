<?php
// [API 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//定义自定义的配置目录
define('CONF_PATH', __DIR__ . '/../config/');

ini_set('opcache.revalidate_freq',0);
//绑定api模块
define('BIND_MODULE','api');

// 加载框架引导文件
//require __DIR__ . '/../thinkphp/start.php';

require __DIR__ . '/../thinkphp/base.php';// 加载框架基础文件

\think\App::route(false);//关闭路由

\think\App::run()->send();// 执行应用
