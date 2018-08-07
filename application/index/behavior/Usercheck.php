<?php
/**
* index module  behavior user check
* before_behavior
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\index\behavoir
* @date 2018.08.01 09:12
*/

namespace app\index\behavior;

class UserCheck
{
	/**
	 * 自动执行run方法
	 * 检测传入的参数是否无效
	 * @access public
	 * @return bool
	 */
	public function run()
	{
		if ('user/0'==request()->url()) {
			return false;
		}
		return true;
	}
}