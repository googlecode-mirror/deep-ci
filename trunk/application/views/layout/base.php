<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>deep-ci</title>

<script type="text/javascript" src="<?=js_url()?>lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=js_url()?>common.js"></script>
<style type="text/css">
body,td,th,a {font-size: 12px;}
a {color: #000000;text-decoration: underline;}

.tab_a {border-collapse:collapse;border:1px solid #A6D352;background:#FFF;width:93%; margin:5px auto; margin-bottom:10px;text-align:left; vertical-align:middle;}
.tab_a td, .tab_a th{ line-height:25px; padding:1px 5px;border:1px solid #A6D352; }
.tab_a th{ padding: 1px 2px; padding-left:8px;padding-right:8px;background:#D1E9A5; font-size:14px;}
.tab_a .sepa { border-collapse:separate;}
.tab_a .menu { text-align:right; font-size:14px; font-weight:normal; padding-left:8px}
.tab_a .sub_menu td {text-align:center; }
.tab_a .sub_footer {text-align:left; background:#D1E9A5;}
.tab_a .page_bar {text-align:center; font-size:12px; font-weight:normal;}


.tal{text-align:left;}
.tac{text-align:center;}
.tar{text-align:right;}

#layout{width:832px; border: solid 1px #999; margin:15px auto;padding: 10px 5px;}

input{vertical-align:middle;}
form{margin:0;}
</style></head>

<?php
//加載js
if(!empty($_loadJs)) {
	$jsObj =& js();
	foreach($_loadJs as $js)
		$jsObj->load($js);
}
?>
</head>

<body>
<div id="layout">
<table class="tab_a" >
	<tr>
		<th class="menu" style="border:0;text-align:left;font-size:12px;"><?php
			$member = MemberCurrentUser::user();
			if(empty($member->id)) {
		?>
		<a href="<?=site_url('member/login')?>">登陸</a> | <a href="<?=site_url('member/reg')?>">會員註冊</a>
		<?php } else {?>
		<a href="<?=site_url('member')?>"><?=$member->username?></a>， 歡迎登陸！ <a href="<?=site_url('member/logout')?>">登出</a>。
		<?php }?>
		</th>
        <th class="menu" style="border:0;"><a href="<?=site_url()?>">首页</a></th>
	</tr>
</table>
<?php echo $content_for_layout?>
</div>
<div style="text-align:center; color:#666;">Page rendered in {elapsed_time} seconds</div>
</body>
</html>
