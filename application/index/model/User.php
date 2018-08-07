<?php
/**
* model User
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\index\model\
* @access public
* @date 2018.07.26 17:00
*/
namespace app\index\model;

use	think\Model;
use	think\Db;
use think\Request;

class User extends Model
{
	function __construct()
	{
		
	}

	/**
	 * 5.0.2版本开始，如果依赖注入的类有定义一个可调用的静态invoke方法，则会自动调用invoke方法完成依赖注入的自动实例化。
	 * invoke方法的参数是当前请求对象实例
	 * @author zwesy
	 * @date   2018-08-03T10:53:22+0800
	 * @access public
	 * @param  Request                  $request 当前请求对象实例
	 * @return mixed 依赖注入的对象
	 */
	public static function invoke(Request $request)
	{
		$uid = $request->param('id');//从当前请求对象中获取用户id参数
		return User::get($uid);//调用静态方法
	}


	public function userLogin($account){
	 	$data = array();
	 	//原生sql调用 连接类Connection对应的方法来完成
	 	//原生sql 提供了query()和execute()2个方法
		$result = Db::query('select * from mlzm_users where account=:account',['account'=>$account]);
		if(count($result)>0){
			$data = $result[0];
		}
		return $data;
	}
	
	public function getUser($preid = 0,$size= 15)
	{
		if ($preid > 0) {
			$result = Db::name('users')->where('id',$preid)->where('Data_Status',1);
		} else {
			$result = Db::name('users')->where('Data_Status','=',1)->select();
		}
		
	}
	public function addUser($data)
	{
		return Db::table('mlzm_users')->insert($data);
	}
	/*
	public function updateUser($userId)
	{
		Db::table('mlzm_users') ->where('id', $userId) ->update(['NickName' => 'newNickName']);
	}
	
	public function deleteUser($userId)
	{
		//根据主键删除
		//Db::table('mlzm_users')->delete($userId);
		//根据条件删除
		Db::table('mlzm_users')->where('id', $userId)->delete();
		
	} */


	public function dbTest()
	{

	}
}