<?php
/**
 * 应用公共文件(全局公共函数)，common.php 默认自动加载
 * 要让其他的公共函数文件生效需要在配置文件中 extra_file_list 选择中添
 * 其他的公共函数一般存放在common模块下的common文件夹中
 */

use think\Request;
use think\Db;



/**
 * [路由回调检查是否允许用户登录]
 * @author zwesy
 * @date   2018-07-30T09:25:29+0800
 * @return [boolean]
 */
function check_login()
{	
	$enable_login = \think\Config::get('myconfig.user_enable_login');
	if ($enable_login && $enable_login =='off') {
		return false;
	} 
	return true;
}

/**
 * [路由回调检查是否允许用户注册]
 * @author zwesy
 * @date   2018-07-30T09:33:39+0800
 * @return [type]
 */
function check_register()
{
	$enable_register = \think\Config::get('myconfig.user_enable_register');
	if ($enable_register && $enable_register =='off') {
		return false;
	} 
	return true;
}



/**
 * Request中注入对象
 * [description]
 * @author zwesy
 * @date   2018-08-02T20:18:33+0800
 * @access public
 * @param  Request                  $request 请求对象
 * @param  integer                   $uid     用户id
 * @return array                           
 */
function getUserInfo(Request $request, $uid)
{	
	//$db= Db::connect('db_config1');指定连接对象
	//name()会自动加上表前缀，而table()不会。因此使用table()时需要指定完整的表名
	$userinfo = Db::name('users')->where('id',$uid)->find(); 
	//find()查询单条记录，vlaue('id')查询某个字段的值,column('column_value','column_key')查询列的结果集
	return $userinfo;
}

/**
 * 获取表信息
 * @author zwesy
 * @date   2018-08-02T20:22:00+0800
 * @access public
 * @param  string                   $table 完整的表名称
 * @param  string                   $par 【可选】指定某个信息
 * @return mixed                         
 */
function get_table_info($tabl, $par = '')
{
	return Db::getTableInfo($table, $par);
}

