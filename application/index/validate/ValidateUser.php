<?php
/**
* ValidateUser.php
* @author zwesy <zwesy@qq.com>
* @date 2018-07-30
* @time 03:36
*/
namespace app\index\validate;

use think\Validate;

class ValidateUser extends Validate
{
	/**
	 * [$rule 验证规则]
	 * @var [array]
	 */
	protected $rule = [
		'name'		=> 'require|max:25',
		'age'       => 'number|between:10,120',
		'email' 	=> 'email',
	];

	protected $message = [
        'name.require'  =>  '用户名必须',
        'name.max'  	=>  '名称最多不能超过25个字符',
        'age.number'   	=>  '年龄必须是数字',
        'age.between'   =>  '只允许10~120年龄段的用户使用',
        'email' =>  '邮箱格式错误',
    ];
    
    protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];
	

}