<table class="tab" >
  <tbody><tr class="event">
	<td class="tar"><a href="<?=site_url('admin/member')?>">列表</a> | <a href="<?=site_url('admin/member/add')?>">添加</a></td>
  </tr>
</tbody></table>

<form action="<?=site_url('admin/member')?>" method="post">
<table class="tab tab_content autoClass">
  <tr>
	<th width="15%" class="tal">搜索</th>
	<th width="35%">&nbsp;</th>
	<th width="15%">&nbsp;</th>
	<th>&nbsp;</th>
  </tr>
  <tr>
	<td>username</td>
	<td><input type="text" name="username__like__m" value="<?=$sData->get('username')?>"></td>
	<td>passowrd</td>
	<td><input type="text" name="passowrd__like" value="<?=$sData->get('passowrd')?>"></td>
  </tr>
  <tr>
	<td>email</td>
	<td><input type="text" name="email__like" value="<?=$sData->get('email')?>"></td>
	<td>create_date</td>
	<td><input type="text" name="create_date__like" value="<?=$sData->get('create_date')?>"></td>
  </tr>
  <tr>
	<td></td>
	<td colspan="3"><input type="submit" value="提交">  <input type="button" value="清除" class="search_clean"></td>
  </tr>
</table>
</form>

<table id="icc" class="tab tab_content sortabletable autoClass" <?php echo $pageBar['sort'];?>>
  <tr class=".myth">
	<th class="sort" sort_field="m.id">id</th>
	<th class="sort" sort_field="username">username</th>
	<th class="sort" sort_field="passowrd">passowrd</th>
	<th class="sort" sort_field="email">email</th>
	<th class="sort" sort_field="create_date">create_date</th>
	<th class="tal">操作</th>
  </tr>
  <?php foreach($listRows as $r) {?>
  <tr>
	<td><?=$r->id;?></td>
	<td><?=$r->username;?></td>
	<td><?=$r->passowrd;?></td>
	<td><?=$r->email;?></td>
	<td><?=$r->create_date;?></td>
	<td><a href="<?=site_url('admin/member/edit/'.$r->id)?>">修改</a> | <a href="<?=site_url('admin/member/delete/'.$r->id)?>" class="confirm" title="您確定要刪除？刪除后數據將無法恢復！">刪除</a></td>
  </tr>
  <?php }?>
</table>

<table class="tab">
  <tr>
	<td class="tac" style="text-align:left;"><?php echo $pageBar['html'];?></td>
	<td class="tac" style="text-align:right;"><?php echo $pageBar['select'];?></td>
  </tr>
</table>	