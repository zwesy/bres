<?php
namespace app\index\model;

use think\Model;
use	think\Db;
use think\Request;

class Products extends Model
{	
	//自动注入方法,需要继承Model基类
	public static function invoke(Request $request)
	{
		$id = $request->param('id');
		return Products::get($id);//基于Model类的方法,可重写
	}


	public function getproducts($prevId = 0, $page = 1, $size = 15)
	{
		$map = array();
		$map['c.data_status'] = ['=',':status'];
		if($prevId > 0){ //表示接着上一条数据往后查询数据，避免界面出现重复的值
			$map['id'] = ['>', $prevId];
			$page = 1;
		} 

		$join = [
			['mlzm_users','u.id= c.u_id', 'LEFT'],
			['mlzm_type','t.id= c.Type_ID', 'LEFT'],
			['mlzm_area','area.id= c.city_id', 'LEFT'],
		];

		$filed = [
			'c.id','c.title','c.intro','c.time','c.address',
			'c.city_id','area.name'=>'city_name',
			'c.u_id'=>'user_id','u.nickname'=>'user_name',
			'u.head'=>'user_head','u.sex'=>'user_sex',
			'c.type_id','t.name'=>'type_name',
			'c.img','c.img_s','c.likes','c.comms','c.hits',
		];

		
		$result = Db::table('mlzm_content')
		//->fetchSql(true)//不执行sql ，而是返回生成的sql语句
		->alias(['mlzm_content'=>'c','mlzm_users'=>'u','mlzm_type'=>'t','mlzm_area'=>'area'])
		->join($join)// left join
		->field($filed)//field()过滤字段
		->where($map)
		->bind(['status'=>[1,\PDO::PARAM_INT]])
		->order('c.time desc')
		->limit($size)->page($page) 
		->select();
		//$list = Db::name('content')->where($map)->paginate($size);分页查询
		//$list->reader();
		//Db::getLastSql();SQL 调试:解析最近生成的sql,Db::table('table_mane')->getLastSql(),获取指定表的最近sql语句
		//
		//表达式查询
		// $arr = Db::table('mlzm_content')->fetchSql(true)->where('id','exp',' IN (1,3,8) ');
		// dump($arr);
		// 
		// 预处理绑定参数，防SQL注入在执行bind(['id'=>[10,\PDO::PARAM_INT],'name'=>'thinkphp'])
		
		
		return $result;
	}
}