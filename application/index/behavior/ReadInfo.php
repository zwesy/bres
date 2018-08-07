<?php
/**
* index module  behavior read user info 
* after_behavior
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\index\behavoir
* @date 2018.08.01 09:12
*/

namespace app\index\behavior;

use \app\common\model\User;

class ReadInfo
{	
	/**
	 * 自动执行run方法
	 * 读取用户信息
	 * @access public
	 * @return void
	 */
	public function run()
	{	
		$uid = request()->route('id');//id 为路由配置中定义的参数
		//对象注入，可在其他地方调用该对象信息$user = Request::instance()->user;
		request()->user = User::getInfo($uid);
	}
}