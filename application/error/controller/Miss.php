<?php
namespace app\error\controller;
use think\Controller;

class Miss extends Controller
{	
	private $userInfo = array(); 

	public function _initialize()
	{
		$cookie_userinfo = cookie('user');
		$session_userinfo = session('user');
		if (isset($cookie_userinfo)) {
			$this->userInfo = $cookie_userinfo;
		} elseif (isset($session_userinfo)) {
			$this->userInfo = $session_userinfo;
		}
	}

	/**
	 * [unfound 404]
	 * @author zwesy
	 * @date   2018-07-30T05:46:05+0800
	 * @return [mixed]
	 */
	public function unfound()
	{	
		/**
		 * 如果模板不是指向默认view下的话需要指定文件后缀名
		 * 模板文件是独立于控制器和方法存在的
		 * ./ 表示网站根目录
		 */
		//return $this->fetch('./template/error/404.shtml');
		$this->assign([
			'user_data' => $this->userInfo,
        	'site_name' => '404 -- sorry page unfound',
        ]);
		return $this->fetch('error/404');
	}
	
}