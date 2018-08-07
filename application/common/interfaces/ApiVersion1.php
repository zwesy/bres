<?php
namespace app\common\interfaces;

interface ApiVersion1{
	//traits 特性
	const  API_VERSION = 'V1'; //接口的属性必须为常量
	
	//methods
	//接口的方法必须是public【默认public】，且不能有函数体,  接口不能实例化
	//接口的方法实现过程参数必须一一对应

	/**
	 * [登录]
	 * @access public
	 * @param  string  $license 通行账号
	 * @param  string  $password 密码
	 * @param  string  $code     手机验证码登录（存在表示$license为手机号）
	 * @return array
	 */
	public function login($license,$password = '',$code = ''); 
	/**
	 * [注册]
	 * @access public
	 * @return array
	 */
	public function register();
	/**
	 * 搜索
	 * @access public
	 * @return array
	 */
	public function search();
}