<?php
/*
配置目录
|--application                  应用目录   
|--confing                      自定义配置目录
|    |--config.php              应用配置文件
|    |--database.php            数据库配置文件
|    |--home.php                数据库配置文件-场景配置home
|    |--office.php              数据库配置文件-场景配置office
|    |--route.php               路由配置文件
|    |--extra                   应用扩展配置目录
|        |--myconfig.php        自定义扩展配置文件  
|        |--          
|    |--index                   index模块配置文件目录
|        |--extra               index模块扩展配置目录
|        |--config.php          index模块配置文件
|        |--database.php        index模块数据库配置文件
*/





return [
	// +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
	
	// 应用调试模式,调试模式下不能动态配置
    'app_debug'              => true,
    // 应用Trace调试
    'app_trace'              => true,
    // 应用模式状态(针对不同环境下数据库的连接方案,如home.php和office.php  )
    //默认为database.php 设置了app_status后database.php失效
    'app_status'             => 'home',

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------


	// +----------------------------------------------------------------------
	// | URL设置
	// +----------------------------------------------------------------------

	// 是否开启路由
    'url_route_on'           => true,
    // 是否强制使用路由,(开启可使miss路由生效)
    'url_route_must'         => true,
    //采用混合路由模式时，配置了路由的必须使用路由规则，未配置的可用PATH_INFO方式访问

    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route','routegroup','routealias'],

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    // 视图输出字符串内容替换
    'view_replace_str'       => [
    	'__ROOT__'			 => '/',
    	'__EXT__'			 => '/static/ext',
    	'__PLUGINS__'		 => '/plugins',
    ],


    


    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 显示错误信息
    'show_error_msg'         => true,


    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '1',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],


    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
    'trace'                  => [
        // 内置Html Console 支持扩展
        'type' => 'Html',
        'trace_tabs' =>  [
			'base'=>'基本',
			'file'=>'文件',
			'info'=>'流程',
			'error|notice'=>'错误',
			'sql'=>'SQL',
			'debug|log'=>'调试'
     	]
    ],

];

/**
 * 配置参数支持作用域的概念，默认情况下，所有参数都在同一个系统默认作用域下面。如果你的配置参数需要用于不同的项目或者相互隔离，那么就可以使用作用域功能，作用域的作用好比是配置参数的命名空间一样。
 */
/* 动态配置
 导入my_config.php中的配置参数，并纳入user作用域
think\Config::load('my_config.php','','user'); 
 解析并导入my_config.ini 中的配置参数，读入test作用域
think\Config::parse('my_config.ini','ini','test'); 
 设置user_type参数，并纳入user作用域
think\Config::set('user_type',1,'user'); 
 批量设置配置参数，并纳入test作用域
think\Config::set($config,'test'); 
读取user作用域的user_type配置参数
think\echo Config::get('user_type','user'); 
 读取user作用域下面的所有配置参数
dump(Config::get('','user')); 
dump(config('',null,'user')); // 同上
 判断在test作用域下面是否存在user_type参数
think\Config::has('user_type','test'); */