<?php
/**
* admin module  index 
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application\admin\controller
* @date 2018.07.31 22:50
*/
namespace app\admin\controller;

use think\Controller;
use think\Config;
use think\Request;

class Index extends Controller
{
	
	private $valid_key;

	function _initialize() 
	{
		$data =array();
		$data['code'] = 0;
		$data['error_code'] = 0;
		$data['error_message'] = '';


		$static_key = Config::get('myconfig.admin_key');
		$request =Request::instance();//实例化Request对象
		//获取传递的参数
		//$request->param();
		$this->valid_key = md5(date('Ymd').$static_key,false);
		$check_key = validate_key($static_key,$this->valid_key);
		//验证是否可进行下一步操作

		if (!$check_key) {
			$data['code'] = 403;
			$data['error_code'] = 403403;
			$data['error_message'] = 'your key is validate faild';

			//构造函数里或初始化方法不能用return和框架提供的json方法
			echo json_encode($data);
			exit;
		}

	}
	
	public function index()
	{
		$this->assign([
    		'site_name'	=> '后台主页-BRES',
    	]);
    	
    	return $this->fetch('admin/main');
	}

	public function showconfig()
	{
		dump(Config::get());
	}

	/**
	 * [自动生成定义文件]
	 * @author zwesy
	 * @date   2018-08-01T05:26:33+0800
	 * @access public
	 * @return [void]
	 */
	public function buildfiles()
	{	//调用定义好的函数
		build_modules();
	}
}