<?php

return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'anlinglee',
    // 用户名
    'username'        => 'phone',
    // 密码
    'password'        => 'zw125408',
    // 端口
    'hostport'        => '3306',
    // 连接dsn
    //'dsn'             => 'mysql:host=127.0.0.1;port=3306;dbname=anlinglee;charset=utf8',
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [
		\PDO::ATTR_CASE         => \PDO::CASE_LOWER,
	],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => 'mlzm_',
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
	// 开启断线重连
	'break_reconnect' => true,
];

/*
也可同时设置多个数据库连接信息
return [
    "db_config1"=>[
        在这填写db_config1数据库连接信息
    ],
    "db_config2"=>[
        在这填写db_config2数据库连接信息
    ],
];

在调用连接时用
Db::connect('db_config1');
Db::connect('db_config2');

或者在model 类中动态设置，需要继承Model基类

动态自定义：
protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'thinkphp',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => '',
        // 数据库连接端口
        'hostport'    => '',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'think_',
    ];


//在模型里单独设置数据库连接信息
namespace app\index\model;

use think\Model;

class User extends Model
{
    // 直接使用配置参数名
    protected $connection = 'db_config1';
}


##hinkPHP的数据库连接是惰性的，所以并不是在实例化的时候就连接数据库，而是在有实际的数据操作的时候才会去连接数据库。
 */