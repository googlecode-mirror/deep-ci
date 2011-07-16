<table class="tab_menu">
  <tbody><tr>
	<td><a href="<?=site_url('admin/member')?>">列表</a> | <a href="<?=site_url('admin/member/add')?>">添加</a></td>
  </tr>
</tbody></table>

<?php
$validation = DeepCI::createValidation('PdoMember', $member->toArray());
?>

<form action="<?=site_url('admin/member/edit_do/'.$member->id)?>" method="post">
<table class="tab_form autoClass">
    <tr>
        <th colspan="2">修改</th>
    </tr>
	<tr>
        <td width="12%">username</td>
		<td>
			<input type="text" <?php echo $validation->getSubInputHtml('username'); ?>/>
			<?php $validation->getMessageSpanHtml(); ?>
		</td>
    </tr>
	<tr>
        <td>passowrd</td>
		<td>
			<input type="text" <?php echo $validation->getSubInputHtml('passowrd'); ?>/>
			<?php $validation->getMessageSpanHtml(); ?>
		</td>
    </tr>
	<tr>
        <td>email</td>
		<td>
			<input type="text" <?php echo $validation->getSubInputHtml('email'); ?>/>
			<?php $validation->getMessageSpanHtml(); ?>
		</td>
    </tr>
	<tr>
        <td>create_date</td>
		<td>
			<input type="text" <?php echo $validation->getSubInputHtml('create_date'); ?>/>
			<?php $validation->getMessageSpanHtml(); ?>
		</td>
    </tr>
	<tr>
        <td>&nbsp;</td>
		<td><input type="submit" value="提交"/></td>
    </tr>
</table>
</form>