<table class="tab_line" style="margin-top:-18px;">
  <tbody><tr class="event">
	<td class="tar"><a href="<#=site_url('<?php echo $controller_base_url; ?>')#>">列表</a> | <a href="<#=site_url('<?php echo $controller_base_url; ?>/add')#>">添加</a></td>
  </tr>
</tbody></table>

<form action="<#=site_url('<?php echo $controller_base_url; ?>')#>" method="post">
<table class="tab autoClass">
  <tr>
	<th width="15%" class="tal">搜索</th>
	<th width="35%">&nbsp;</th>
	<th width="15%">&nbsp;</th>
	<th>&nbsp;</th>
  </tr>
  <tr>
	<td><?php echo $columns[1];?></td>
	<td><input type="text" name="<?php echo $columns[1];?>__like" value="<#=$sData->get('<?php echo $columns[1];?>')#>"></td>
	<td><?php echo $columns[2];?></td>
	<td><input type="text" name="<?php echo $columns[2];?>__like" value="<#=$sData->get('<?php echo $columns[2];?>')#>"></td>
  </tr>
  <tr>
	<td><?php echo @$columns[3];?></td>
	<td><?php if(!empty($columns[3])) {?><input type="text" name="<?php echo $columns[3];?>__like" value="<#=$sData->get('<?php echo $columns[3];?>')#>"><?php }?></td>
	<td><?php echo @$columns[4];?></td>
	<td><?php if(!empty($columns[4])) {?><input type="text" name="<?php echo $columns[4];?>__like" value="<#=$sData->get('<?php echo $columns[4];?>')#>"><?php }?></td>
  </tr>
  <tr>
	<td></td>
	<td colspan="3"><input type="submit" value="提交">  <input type="button" value="清除" class="search_clean"></td>
  </tr>
</table>
</form>

<table class="tab tab_content_list sortabletable autoClass" <#php echo $pageBar['sort'];#>>
  <tr>
<?php foreach($columns as $c) {?>
	<th class="sort" sort_field="<?php echo $c;?>"><?php echo $c;?></th>
<?php }?>
	<th class="tal">操作</th>
  </tr>
  <#php foreach($listRows as $r) {#>
  <tr>
<?php foreach($columns as $c) {?>
	<td><#=$r-><?php echo $c;?>;#></td>
<?php }?>
	<td><a href="<#=site_url('<?php echo $controller_base_url; ?>/edit/'.$r->id)#>">修改</a> | <a href="<#=site_url('<?php echo $controller_base_url; ?>/delete/'.$r->id)#>" class="confirm" title="您確定要刪除？刪除后數據將無法恢復！">刪除</a></td>
  </tr>
  <#php }#>
</table>

<table class="tab_line">
  <tr>
	<td class="tac" style="text-align:left;"><#php echo $pageBar['html'];#></td>
	<td class="tac" style="text-align:right;"><#php echo $pageBar['select'];#></td>
  </tr>
</table>	