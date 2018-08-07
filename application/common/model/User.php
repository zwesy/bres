<?php
namespace app\common\model;

use think\Model;
use think\Db;

class User extends Model
{
	/**
	 * 获取用户信息
	 * @author zwesy
	 * @date   2018-08-02T17:16:35+0800
	 * @access public
	 * @param  integer   $uid 用户id
	 * @return array      用户信息
	 */
	public function getInfo($uid)
	{	

		//查询一条数据用find(),查询数据集用select()
		//name()会根据设置表前缀自动补全表名
		//table()必须传入完整的表名
		$userinfo = Db::name('users')->where('id',$uid)->find(); 
		return $userinfo;
	}
}