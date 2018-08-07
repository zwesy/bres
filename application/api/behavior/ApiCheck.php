<?php
/**
* index module  behavior api check
* before_behavior
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\index\behavoir
* @date 2018.08.01 09:12
*/

namespace app\api\behavior;

class ApiCheck
{
	/**
	 * 自动执行run方法
	 * 检测传入的url参数是否无效
	 * @access public
	 * @return bool
	 */
	public function run()
	{
		if ('api'==request()->url()) {
			
			return false;
		}
		return false;
	}
}