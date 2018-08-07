<?php 
/**
* User Controller
* @access public
* @package	application\index\controller\
* @author zwesy <zwesy@qq.com>
*/
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Loader;

use \app\index\model\User as UserTable;
use \validate\PassCrypt;
use \validate\PasswordHash;
use \tools\Tools;


class User extends Controller
{
	private static $key='bresadminkey';
	private static $default_password = 'www.bres.com';
	private $validate_key;
	private $userInfo = array();

	
	public function _initialize()
	{	
		$keyword = date('Y-m-d',time());
		//TRUE - 原始 16 字符二进制格式;FALSE - 默认。32 字符十六进制数
		$this->validate_key = md5($keyword.self::$key,false);

		$cookie_userinfo = cookie('user');
		$session_userinfo = Session::get('user');
		if (isset($cookie_userinfo)) {
			$this->userInfo = $cookie_userinfo;
		} elseif (isset($session_userinfo)) {
			$this->userInfo = $session_userinfo;
		}
	}
	
	
    /**
     * [登录]
     * @author zwesy
     * @date   2018-07-30T09:38:22+0800
     * @param  [string] 	$account
     * @param  [string]	$password
     * @return [array]
     */
	public  function login()
	{	
		$data = array();
		$data['code'] = 200;
		$data['error_code'] = 0;
		$data['error_message'] = '';

		//$request = Request::instance();
		//$method = $request->method(); 获取访问上传方式
		//Request::instance()->header('user-agent');获取user-agent请求头（字符串）
		//Request::instance()->ip();获取IP（字符串）

		$params = input('param.');//获取所有，不分get、post、put。。
		//$gets = input('get.');//获取所有get请求来的参数
		//$posts = input('post.');

		if (isset($params['account']) && isset($params['password'])) {
			//去空和把预定义字符转换为HTML 实体
			$account = htmlspecialchars(trim($params['account']));
			$password = htmlspecialchars(trim($params['password']));

			$UserTable = new UserTable;
			$result = $UserTable -> userLogin($account);
			
			//验证是否存在该用户
			if ($result) {
				$pwd = $result['password'];
			} else {
				$data['code'] = 404;
				$data['error_code'] = 404401;
				$data['error_message'] = '该账户不存在,请先注册再登陆';
				return json($data);
			}
			
			//加载第3方加密类库
			Loader::import('validate.WpPasswordHash', EXTEND_PATH);
			$wp_hasher = new \WpPasswordHash(8, TRUE); 
			$isverify = $wp_hasher->CheckPassword($password, $pwd);
			if ($isverify) {
				//验证通过,添加会话机制 session & cookie
				$cookie_user_ary = [
					'id'=>$result['id'], 'account'=>$result['account'], 'nickname'=>$result['nickname'],
				 	'head'=>$result['head'],'city_id'=>$result['city_id']
				];
				//setcookie('user',$cookie_user_ary,time()+3600*24*7);原生的方法设置7天有效时间
				$cookie_userinfo = cookie('user');
				if(!isset($cookie_userinfo)){
					Cookie('user',$cookie_user_ary,time()+3600*24*7);
				}
				Session::set('user', $cookie_user_ary);
			}
		} else {
			$data['code'] = 400;
			$data['error_code'] = 400400;
			$data['error_message'] = '传入参数不正确,请检查后重新提交';
		}
		return json($data);
	}

	
	/**
	 * [注册]
	 * @author zwesy
	 * @date   2018-07-30T09:53:45+0800
	 * @param  [string]		$license    通行证
	 * @param  [string]		$account    用户名         
	 * @param  [string]		$password    密码
	 * @param  [integer]	$validate_code    验证码
	 * @return [integer]	生成的用户id
	 */
	public function register()
	{	
		$data = array();
		$data['code'] = 0;
		$data['error_code'] = 0;
		$data['error_message'] = '';

		$params = input('params.');
		$checked = true;//检测传入参数是否正确
		$license_type = 0;//1 => telnumber, 2 => email

		if (!isset($params['account'])) {
			$checked = false;
		}
		if (!isset($params['password'])) {
			$checked = false;
		}
		if (isset($params['license'])) {
			if (preg_match("/^1[34578]{1}\d{9}$/", $params['license'])) {
				$license_type = 1;//验证是否为合法手机号
			} elseif (filter_var($params['license'], FILTER_VALIDATE_EMAIL)) {
				$license_type = 2;//验证是否为合法邮箱
			} else {
				$checked = false;
			}
		} else {
			$checked = false;
		}
		
		//验证验证码是否正确，调用验证后，删除数据记录
		//....

		if ($checked) {
			//去空和预定义字符转换为 HTML 实体
			$params = Tools::htmlEntity($params);
			$PassCrypt = new PassCrypt();
			$password_crypt = $PassCrypt->encrypt($params['password']);

			$UserTable = new UserTable;
			$result = $UserTable -> userRegister($params['account'],$password_crypt,$params['license'],$license_type);
		} else {
			$data['code'] = 0;
			$data['error_code'] = 500501;
			$data['error_message'] = '参数格式不正确，请检查后重试';
		}
	}


	public function test()
	{	
		/*//引入第3方类库
		//import('validate.PasswordHash', EXTEND_PATH);
		Loader::import('validate.WpPasswordHash', EXTEND_PATH);
		$wp_hasher = new \WpPasswordHash(8, TRUE); 
		$pwd = 'zw125408';
		//加密
		$pwd_crypt = $wp_hasher->HashPassword($pwd); 
		//验证密码
		echo $wp_hasher->CheckPassword($pwd,'$P$B/YwAsTD0UJ4GK6d82Xuf/X2FKuN5j1');*/
		$PassCrypt = new PassCrypt();
		$password_crypt = $PassCrypt->encrypt('zw125408');
		dump($password_crypt);
	}


}