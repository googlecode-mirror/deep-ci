<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理系統</title>
<link href="<?=style_url('admin');?>css/admin_css.css" rel="stylesheet" type="text/css" />
<link href="<?=style_url('admin');?>css/css.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="<?=style_url('admin');?>css/admin_css_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<script type="text/javascript" src="<?=js_url()?>lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=js_url()?>common.js"></script>

<?php
//加載js
if(!empty($_loadJs)) {
	$jsObj =& js();
	foreach($_loadJs as $js)
		$jsObj->load($js);
}
?>
</head>

<body class="admin_page">
<div id="container">
  <div id="header">
  
  <!-- end #header -->
  <img src="<?=style_url('admin');?>images/inner_logo.gif" /></div>

  
  <div id="sidebar1" >
<!-- 第一段菜單内容---------------------->
<div id="treenav">
<ul>
  <li><a href="#" onclick="return false;" class="listhead"><?=$_SESSION['admin_info']['username']?>, 歡迎您！</a> 
    <ul class="expanded" id="submenuid0"><!--第二級 -->
	  <li><a href="<?=site_url('admin')?>">首頁</a></li>
    </ul>
  </li>
</ul>
<ul>
  <li><a href="#" onclick="return false;" class="listhead">會員&排名管理</a> 
    
	<ul class="expanded">
	  <li><a href="<?=site_url('admin/member')?>">會員管理</a></li>
	  <li><a href="<?=site_url('admin/rank')?>">排名管理</a></li>
    </ul>
	
  </li>
</ul>
<ul>
  <li><a href="#" onclick="return false;" class="listhead">其他</a> 
    <ul class="expanded">
	  <li><a href="<?=site_url('admin/user/logout')?>">登出</a></li> 
    </ul>
  </li>
</ul>
<!--- end -------------------> 
</div>

  <!-- end #sidebar1 --></div>
  <div id="mainContent">
	<h1><img src="<?=style_url('admin');?>images/icon_title.gif" width="11" height="11" align="absmiddle" />&nbsp;<?php echo @$layout_title; ?></h1>
  	<?php echo $content_for_layout; ?>
	<p>&nbsp;</p>
  </div><!-- end #mainContent -->

  <br class="clearfloat" />  <div id="footer"><img src="<?=style_url('admin');?>images/page_root_left.gif" align="left" />
<p>Copyright 2009 &copy; name.080.net All rights reserved. Power by：<a href="http://name.080.net/domain" target="_blank">name080</a></p>
  <!-- end #footer -->
</div>
<!-- end #container --></div>
</body>
</html>