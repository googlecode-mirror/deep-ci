<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理系統</title>
<link href="<?=style_url('admin')?>css/admin_css.css" rel="stylesheet" type="text/css" />
<link href="<?=style_url('admin')?>css/css.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="<?=style_url('admin')?>css/admin_css_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<style type="text/css">
<!--
body {
	background-color: #f4f4f4;
}
-->
</style>
</head>

<body class="admin_index">

<div id="container">
  <div id="header">
  <!-- end #header --></div>
  <form method="post">
  <div id="mainContent">
    <label>帳號：</label>
    <input type="text" name="username" id="username" /><br />
    <label>密碼：</label>
    <input type="password" name="password" id="password" />
    <label>&nbsp;</label>
    <input type="image" src="<?=style_url('admin')?>images/btn_login.gif" style="border:0px;"/>
	<!-- end #mainContent -->
  </div>
  </form>
  <div id="footer">
<p>Copyright 2009 &copy; name.080.net All rights reserved. Power by：<a href="http://name.080.net/domain" target="_blank">name080</a>
  <!-- end #footer -->
</p>
</div>
<!-- end #container --></div>
</body>
</html>
