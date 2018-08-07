+------------------------------------------------------------------------+
查看表结构:
1.简答查看
desc table_name;
显示表结构，字段类型，主键，是否为空等属性，但不显示外键。

2.查询表中列的注释信息
select * from information_schema.columns
where table_schema = 'db' #表所在数据库
and table_name = 'tablename' ; #你要查的表

3.只查询列名和注释
select column_name, column_comment from information_schema.columns 
where table_schema ='db' 
and table_name = 'tablename' ;

4.查看表的注释
select table_name,table_comment from information_schema.tables 
where table_schema = 'db' 
and table_name ='tablename'

5.查看表生成的DDL 
show create table table_name;(常用指令)
这个命令虽然显示起来不是太容易看， 这个不是问题可以用\G来结尾，使得结果容易阅读；
该命令把创建表的DDL显示出来，于是表结构、类型，外键，备注全部显示出来了。

参考:https://www.cnblogs.com/zhangyuhang3/p/6873895.html

+------------------------------------------------------------------------+

规则 rule 

上传的文件/upload/images/year(4字符)/month(2字符)/当前时间戳(10字符)+随机数(5字符)+后缀名(5字符)
如:/upload/images/2018/07/153296658423425.jpg
$filename='/upload/images/'.date('Y', time()).'/'.date('m', time()).'/'.time().mt_rand(10000,99999).$ext;


+-------------------------------------------------------------------------+

bres_user表

id MEDIUMINT[2^23-1]  AUTO_INCREMENT=1(自增步长)  PRIMARY KEY	not null
account varchar(30) 最多30个字符，若仅考虑汉字和短字母的话20个字符够了	not null (唯一,可用于登陆)
password	char(60) 加密后固定长度的hash值	 not null
telnumber	char(11) 手机号	（若只允许绑定手机注册 not null）(唯一,可用于登陆)
email		varchar(50) 最多50个字符，通常邮箱地址在20个字符以内(非唯一,用于密码找回)
regtime		timestamp(具有自动更新特性，1970~2037 时间范围较短，但满足一般需求) ，生成环境中一般用数字表示, 注册时间
head        varchar(100)     头像地址，根据实际开发设计来设计长度 （/upload/year/month/filename[当前时间戳+随机码]）	
nicename	varchar(30) 昵称 not null   默认为用户名
introduction  varchar(200) 个人简介
age			tinyint		默认0 用触发器对比生日来生成(删除该属性,无必要,需要用到的时候根据birthday来转换)
birthday	date	yyyy-mm-dd
sex         tinyint    性别（默认1女，2男）
status	 	tinyint   (1为数字表示用户账号的状态，默认1 正常)    not null
 
#传入的license 通信证验证 用户名必须以字母开头，其次进行手机号验证，最后才进行邮箱验证，验证都通不过表示无效通行证


CREATE TABLE `bres`.`bres_user` (
	`id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`account` VARCHAR (30) NOT NULL COMMENT '用户名（唯一）',
	`password` CHAR (60) NOT NULL COMMENT '加密后的密码',
	`nicename` VARCHAR (30)  COMMENT '昵称',
	`telnumber` CHAR (11)  COMMENT '手机号（唯一）',
	`email` VARCHAR (50)  COMMENT '邮箱',
	`head` VARCHAR (50)  COMMENT '头像',
	`introduction` VARCHAR (200) COMMENT '个人简介，最多200个字符',
	`regtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
	`age` TINYINT NOT NULL DEFAULT '0' COMMENT '年龄',
	`birthday` DATE COMMENT '生日',
	`sex` TINYINT NOT NULL DEFAULT '1' COMMENT '性别（默认1女，2男）',
	`status` TINYINT NOT NULL DEFAULT '1' COMMENT '用户状态（默认1正常，2被封禁，10失效）',
	PRIMARY KEY (`id`),
	INDEX `stat` (`status`) USING HASH,
	INDEX `user_vd` (`email`, `sex`) USING HASH,
	UNIQUE `unique_user` (`account`, `telnumber`) USING HASH
) ENGINE = INNODB CHARSET = utf8 COLLATE utf8_general_ci COMMENT = '用户表';

#视图参考:https://www.cnblogs.com/geaozhang/p/6792369.html#chakanshitu

触发器
#参考https://www.cnblogs.com/CraryPrimitiveMan/p/4206942.html
https://www.cnblogs.com/zhangzhongxian/p/7070277.html

#对同表当前数据更新不能使用update ,而是使用SET
注意系统默认的分割符为';'号,而sql语句的结束符也是';'号,
因此为了不冲突需要在创建触发器的时候重新定义分隔符,触发器执行完毕后恢复默认分隔符

after触发器—是在记录操纵之后触发，是先完成数据的增删改，再触发，触发的语句晚于监视的增删改操作，无法影响前面的增删改动作
before触发器—是在记录操纵之前触发，是先完成触发，再增删改，触发的语句先于监视的增删改，我们就有机会判断，修改即将发生的操作，如：我们在触发之前需要判断new值和old值的大小或关系，如果满足要求就触发，不通过就修改再触发；如：表之间定义的有外键，在删除主键时，必须要先删除外键表，这时就有先后之分，这里before相当于设置了断点，我们可以处理删除外键。

对于INSERT语句, 只有NEW是合法的；
对于DELETE语句，只有OLD才合法；
对于UPDATE语句，NEW、OLD可以同时使用。

NEW 与 OLD 详解
在 INSERT 型触发器中，NEW 用来表示将要（BEFORE）或已经（AFTER）插入的新数据；
在 UPDATE 型触发器中，OLD 用来表示将要或已经被修改的原数据，NEW 用来表示将要或已经修改为的新数据；
在 DELETE 型触发器中，OLD 用来表示将要或已经被删除的原数据；
使用方法： NEW.columnName （columnName 为相应数据表某一列名）
另外，OLD 是只读的，而 NEW 则可以在触发器中使用 SET 赋值，这样不会再次触发触发器，造成循环调用（如每插入一个学生前，都在其学号前加“2013”）。


+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
DELIMITER $$
CREATE TRIGGER tri_userInsert BEFORE INSERT ON bres_user FOR EACH ROW
BEGIN
SET @c = (
	SELECT
		FLOOR(
			ABS(
				TIMESTAMPDIFF(
					MONTH,
					NEW.birthday,
					now()
				)
			) / 12
		)
) ;
SET NEW.age =@c ; end$$
DELIMITER ;


INSERT INTO bres_user (
	bres_user.account,
	bres_user.`password`,
	bres_user.telnumber,
	bres_user.email,
	bres_user.nicename,
	bres_user.introduction,
	bres_user.sex,
	bres_user.regtime,
	bres_user.birthday
)
VALUES
	(
		'zwesy',
		'$2y$08$Gj0HBirW/w4Q41J8j2md6uv/XE31SC6xAjvKMmvevPD/bOOxaa41K',
		'13547431637',
		'zwesy@qq.com',
		'zwesy',
		'no say faied',
		2,
		NOW(),
		'1993-09-16'
	);


++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
查看触发器[和查看数据库（show databases;）查看表格（show tables;）一样，查看触发器的语法如下：]
SHOW TRIGGERS [FROM schema_name];
SELECT * FROM information_schema.`TRIGGERS`;
SHOW TRIGGERS //查看所有的触发器
SHOW CREATE TRIGGER tri_userInsert //查看指定的触发器

删除触发器
DROP TRIGGER [IF EXISTS] [schema_name.]trigger_name
drop TRIGGER IF EXISTS tri_userInsert;

触发器的执行顺序
我们建立的数据库一般都是 InnoDB 数据库，其上建立的表是事务性表，也就是事务安全的。这时，若SQL语句或触发器执行失败，MySQL 会回滚事务，有：

①如果 BEFORE 触发器执行失败，SQL 无法正确执行。
②SQL 执行失败时，AFTER 型触发器不会触发。
③AFTER 类型的触发器执行失败，SQL 会回滚。

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++





 
bres_adminuser (权限限制)
privileges varchar(50) not null (用英文逗号分开)

bres_validate 表
id int   auto_increment primary key not null    ------- 删除后回滚auto_increment 到当前最大值+1
ctime	 timestamp	 创建的时间（执行检查时，过期了就删除该信息）not null
code     mediumint	(4位smallint或6位数字mediumint)   not null
license  varchar(50) 绑定的通行证  not null

#1、指定license验证后,返回验证结果并删除记录;
#2、重置auto_increment，先获取剩余数据中最大的id值max(id),auto_increment=max(id)+1


查询表名为tableName的auto_increment值：
SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name="tableName";
修改表名为tableName的auto_increment值：
ALTER TABLE tableName auto_increment=number ;


bres_products 表

CREATE TABLE `bres`.`bres_products` (
	`productid` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR (50) NOT NULL COMMENT '名称',
	`introduction` VARCHAR (200)  COMMENT '简介',
	`description` TEXT  COMMENT '详情',
	`categoryid` SMALLINT UNSIGNED NOT NULL COMMENT '分类id',
	`tags` VARCHAR (55)  COMMENT '标签，多个之间用英文逗号分隔',
	`create_date` TIMESTAMP NOT NULL COMMENT '生产日期',
	`expire` SMALLINT NOT NULL DEFAULT '90' COMMENT '保质期（天），0表示永久有效，默认90天',
	`up_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上架时间',
	`down_date` TIMESTAMP  COMMENT '下架时间',
	`ownerid` MEDIUMINT NOT NULL COMMENT '所属者id',
	`total_num` INT NOT NULL DEFAULT '0' COMMENT '商品总量',
	`current_num` INT NOT NULL DEFAULT '0' COMMENT '商品当前余量',
	`promotion_sum` INT NOT NULL DEFAULT '0' COMMENT '促销商品的总量',
	`promotion_cur` INT NOT NULL DEFAULT '0' COMMENT '促销商品当前余量',
	`status` TINYINT NOT NULL DEFAULT '0' COMMENT '商品状态（默认0待审核，1正常，2热卖，3促销，4缺货，10已下架）',
	`image` VARCHAR (500)  COMMENT '关联图片（单张的地址字符长度小于50，最多支持10张，多个地址间用英文逗号分隔）',
	`bgimage` VARCHAR (50)  COMMENT '封面地址',
	PRIMARY KEY (`productid`),
	INDEX `product_cate` (`tags`, `categoryid`) USING HASH,
	INDEX `pro_owner` (`ownerid`) USING HASH,
	INDEX `pro_status` (`status`),
	INDEX `pro_curnum` (
		`current_num`,
		`promotion_cur`
	) USING BTREE
) ENGINE = INNODB CHARSET = utf8 COLLATE utf8_general_ci COMMENT = '商品表';

ALTER TABLE `bres_products` CHANGE `categoryid` `categoryid` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id，默认0未定义';



#关联：
bres_products.ownerid 	=> bres_user.id
bres_products.categoryid 	=> 	bres_category.categoryid
bres_category.categoryid 删除时bres_products.categoryid变更为默认值0，修改时跟随改动




bres_category 表

CREATE TABLE `bres`.`bres_category` (
	`categoryid` SMALLINT NOT NULL,
	`name` VARCHAR (50) NOT NULL COMMENT '名称',
	`pid` SMALLINT NOT NULL DEFAULT '0' COMMENT '父级分类id',
	`image` VARCHAR (350)  COMMENT '图片描述，多个间用英文逗号分隔',
	`bgimage` VARCHAR (50)  COMMENT '封面',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
	`status` TINYINT NOT NULL DEFAULT '1' COMMENT '状态（默认1已生效，0未生效，10已移除）',
	`adminid` SMALLINT NOT NULL COMMENT '创建的管理员id',
	PRIMARY KEY (`categoryid`),
	INDEX `category_pid` (`pid`) USING HASH,
	INDEX `category_own` (`adminid`) USING HASH,
	INDEX `stat` (`status`) USING HASH
) ENGINE = INNODB CHARSET = utf8 COLLATE utf8_general_ci COMMENT = '分类表';

// 添加自动增长和无符号
ALTER TABLE `bres_category` CHANGE `categoryid` `categoryid` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT;

# bres_products表的categoryid不与bres_category表建立外键关联，是为了避免category删除导致数据丢失，但也损失了修改的联动性


bres_tag 表



bres_adminuser