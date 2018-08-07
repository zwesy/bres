<?php
 /**
* 自定义公共函数 
* @author zwesy <zwesy@qq.com>
* @version 1.0
* @package application
* @date 2018.07.31 8:45
* 要让公共函数文件生效需要在配置文件中 extra_file_list 选择中添加
* 该文件生效要慢于common.php 公共函数文件，如在hook方法注入中无法应用到，
* 只能引用到common.php中定义好的函数，因此推荐函数写在common.php文件中
*/


/**
 * [验证key值的有效性]
 * @author zwesy
 * @date   2018-07-31T23:34:22+0800
 * @access public
 * @param  [string] $key 设置的key值
 * @param  [string] $validKey 需要验证的key值
 * @param  [string] $timezone 时区
 * @return [bool]
 */
function validate_key($key, $validKey, $timezone = '')
{	
	//验证时区
	/**
	 * Etc/GMT 这是格林威治标准时间,得到的时间和默认时区是一样的
	 * Etc/GMT+8 比林威治标准时间慢8小时
	 * Etc/GMT-8 比林威治标准时间快8小时 
	 * Asia/Shanghai – 上海 
	 * Asia/Chongqing – 重庆 Asia/Urumqi – 乌鲁木齐 
	 * Asia/Hong_Kong – 香港 Asia/Macao – 澳门 
	 * Asia/Taipei – 台北 Asia/Singapore – 新加坡 
	 */
	if ($timezone != '') {
		date_default_timezone_set($timezone);
		//\think\Config::set('default_timezone',$timezone);
	}
	
	$rsa_pub = date('Ymd', time()).$key;//每日生成不同的key
	//TRUE - 原始 16 字符二进制格式;FALSE - 默认。32 字符十六进制数
	ini_set('date.timezone','PRC');//时区复原为中国时区北京时间
	//\think\Config::set('default_timezone','PRC');
	$valid_key = md5($rsa_pub,false);
	if ($valid_key === $validKey) {
		return true;
	}
	return false;
}



function build_modules()
{	
	try{
		//读取自动生成定义文件
		$build = include(APP_PATH.'/../build.php');
		//运行自动生成文件
		\think\Build::run($build);
	}
	catch(Exception $e)
	{
		print $e->getMessage();
		exit();
	}
}



