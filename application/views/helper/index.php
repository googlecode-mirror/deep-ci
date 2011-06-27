<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<h1>助手工具</h1>

<form action="<?php echo site_url('helper/update_models');?>">
<p>更新models <input type="submit" value="更新"></p>
</form>

<code>將自動生成或更新<br>
application/models/Model<br>
application/models/Pdo<br>
application/models/Pdo/Base<br>
</code>

<form action="<?php echo site_url('helper/create_controllers');?>">
<p>生成controllers 
PdoName：<input type="text" name="pdo_name"> <span style="color:red">例如： PdoMember</span> 
ViewUrl：<input type="text" name="vire_url"> <span style="color:red">例如： /admin/member</span>
<input type="submit" value="更新"></p>
</form>

<code>將生成 list add edit delete 四種操作</code>

<code>將自動生成<br>
application/controllers<br>
application/views<br>
</code>

<p><br />Page rendered in {elapsed_time} seconds</p>

</body>
</html>