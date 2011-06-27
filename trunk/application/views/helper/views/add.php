<table class="tab" >
  <tbody><tr class="event">
	<td class="tar"><a href="<#=site_url('<?php echo $controller_base_url; ?>')#>">列表</a> | <a href="<#=site_url('<?php echo $controller_base_url; ?>/add')#>">添加</a></td>
  </tr>
</tbody></table>

<#php
$validation = DeepCI::createValidation('<?php echo $Model_PdoName;?>');
#>

<form action="<#=site_url('<?php echo $controller_base_url; ?>/add_do')#>" method="post">
<table class="tab tab_content autoClass">
    <tr>
        <th width="12%">新增</th>
		<th>&nbsp;</th>
    </tr>
<?php foreach($columns as $c) { if($c=='id') continue;?>
	<tr>
        <td><?php echo $c; ?></td>
		<td><input type="text" <#php echo $validation->getSubInputHtml('<?php echo $c; ?>'); #>/> <#php $validation->getMessageSpanHtml(); #>
		</td>
    </tr>
<?php }?>
	<tr>
        <td>&nbsp;</td>
		<td><input type="submit" value="提交"/></td>
    </tr>
</table>
</form>