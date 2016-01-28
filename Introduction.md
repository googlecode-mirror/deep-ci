# 简介 #
这不是一个新的Framwork。

是工作中为了方便快速的开发、基本功能的重用的总结。
是PHP中使用ORM快速开发的实践。

  * PHP 5.2.3+
    * MVC: Farmwork CodeIgniter? (2.0)
    * ORM: Doctrine (1.2)
    * Javascript Based: Jquery


---


# 功能 #
  * [基本说明](BaseInfo.md)
  * [分页](PageBar.md)
  * [jQuery表单验证](jQuery_Validate.md)
    * [PHP生成Js验证](Validation.md)
  * [Doctrine ORM 操作](Doctrine.md)
    * [ORM优点](http://code.google.com/p/deep-ci/wiki/Doctrine#优点)


---


# CodeIgniter 注记 #
```
$CI =& get_instance();
$CI->uri->segment($u);
$CI->uri->rsegment($u); // 开启CodeIgniter的URI路由时使用

redirect('/admin/'); // 第二个参数为 location 定位操作(默认)。速度快
redirect('/admin/', 'refresh');

parse_str($_SERVER['QUERY_STRING'],$_GET); //取得$_GET变量

#显示系统执行状态
Page rendered in {elapsed_time} seconds, and use {memory_usage} memory.
```




# 数据相关约定 #
  * 数据库表的名称以单数命名
  * 數據庫都自增1字段都 命名為 id，其他以單詞+下劃綫
  * 數據庫中儘量避免使用 NULL
  * 时间字段使用 datetime 类型。数据量过大时在考虑转换成int类型。