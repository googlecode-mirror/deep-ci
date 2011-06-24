<table class="tab" >
  <tbody><tr class="event">
	<td class="tar"><a href="<?=site_url('admin/member')?>">列表</a> | <a href="<?=site_url('admin/member/add')?>">添加</a></td>
  </tr>
</tbody></table>

<table id="icc" class="tab tab_content sortabletable autoClass" <?php echo $pageBar['sort'];?>>
  <tr class=".myth">
	<th class="sort" sort_field="id">id</th>
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