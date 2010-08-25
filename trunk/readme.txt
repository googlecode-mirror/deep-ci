== SRC ==
MVC CodeIgniter_1.7.2.zip
ORM Doctrine-1.2.2.tgz

== 基本修改 ==
1、使用 user_controller 來代替 controller 名稱
2、使用 ORM Doctrine
3、增加cli.php 用于命令行执行
(以上修改详见 http://net.tutsplus.com/tutorials/php/6-codeigniter-hacks-for-the-masters/)

=========================
新增 Layout.php 并自动加载
新增 config_commoin.php 并自动加载
新增 自动加载 url helper 
新增 自動加載 common herlper
新增 自動加載 js plugin
修正 Doctrine 設置charset
新增 PageBar功能

=========================
Doctrine 配置，先加載 models/generated 裏面的內容
	Doctrine_Core::loadModels(APPPATH.'models/generated');
	Doctrine_Core::loadModels(APPPATH.'models');
js() 只保留 alert 以及 goto ,goto內部嵌套site_url
數據庫都自增1字段都 命名為 id，其他以單詞+下劃綫
自動加載 libraries 裏面class
新增 PageBarSession 存放搜索條件
增加 VARPATH

Doctrine modelsAutoload
http://www.doctrine-project.org/projects/orm/1.2/docs/manual/introduction-to-models/en#autoloading-models

Doctrine 原始文件 移動到 system下面
=========================
todo
>> jquery Validation
>> captchas
>> 研究php5连续返回