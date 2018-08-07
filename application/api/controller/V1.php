<?php
/**
* api module  v1 
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\api\controller
* @date 2018.07.31 22:50
*/
namespace app\api\controller;

use think\Controller;
use \app\common\interfaces\ApiVersion1;

class V1 extends Controller implements ApiVersion1
{
	/**
     * @param $name
     * 如果在本控制器中找不到该操作那就运行我
     */
    public function _empty($name)
    {
        echo $name.'这个操作不存在';
    }

	function _initialize() 
	{
		
	}
	
	public function index()
	{
		echo 'API V1 INDEX';
	}

	public function login($license,$password = '',$code = '')
	{

	}

	public function register()
	{

	}

	public function search()
	{
		//生成url
		echo \think\Url::build('/api/V1/search');
	}

	/**
	 * [工具方法1]
	 * @access public
	 * @return [void]
	 */
	public function toolfunc1()
	{

	}
	/**
	 * [工具方法2]
	 * @access public
	 * @return [void]
	 */
	public function toolfunc2()
	{

	}
	/**
	 * [工具方法3]
	 * @access public
	 * @return [void]
	 */
	public function toolfunc3()
	{

	}
}