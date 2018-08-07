<?php
/**
* 对不存在的URL进行访问拦截
* 由'empty_controller' 配置项设置空操作拦截
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\admin\controller
* @date 2018.08.01 13:35
*/
namespace app\admin\controller;

class Error 
{	
	/**
	 * [空操作拦截]
	 * @access public
	 * @param  string   $method 方法名
	 * @return void
	 */
	public function _empty($method)
	{
		return '你访问的方法'.$method.'不存在';
	}
}
