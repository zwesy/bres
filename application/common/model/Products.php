<?php
namespace app\common\model;

use think\Model;
use	think\Db;
use think\Request;

class Products extends Model
{	
	//自动注入方法,需要继承Model基类
	public static function invoke(Request $request)
	{
		$id = $request->param('id');
		return Products::get($id);
	}

	public function getproducts($prevId = 0,$size = 15)
	{
		$map = array();
		$map['data_status'] = ['=','1'];
		if($prevId > 0){
			$map['id'] = ['>', $prevId];
		} 
		$result = Db::name('content')->where($map)->limit($size);
		//$result = Db::name('content')->where($map)->paginate($size);
		Db::getLastSql();
		return $result;
	}
}