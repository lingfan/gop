
<?php
$info['server_list'] = !empty($info['server_list'])?$info['server_list']:'';
?>
<style>
	td { padding: 2px}
</style>
<div id="divform">
	<span style="display: none;"><input  name="id" type="hidden" class="ui-textbox" /></span>
	<table>
		<tr>
			<td>
				<label for="name">运营商名称：</label>
			</td>
			<td>
				<input id="name" name="name" type="text" class="ui-textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="name">运营商编号：</label>
			</td>
			<td>
				<input id="code" name="code" type="text" class="ui-textbox"/>
			</td>
		</tr>

		<tr>
			<td>
				<label for="name">服务器列表：</label>
			</td>
			<td>
				<input id="server_ids" name="server_ids" type="hidden" class="ui-listbox" data-isMultiSelect="true"   />
			</td>
		</tr>
	</table>
</div>

<script>

	$(function () {
		$("#divform").ligerForm();

		$("#server_ids").ligerListBox({
			url: '<?php echo '?r=Server/ComboBox'?>'
		});

		var form = liger.get("divform");
		form.setData(<?php echo !empty($info)?json_encode($info):'';?>);
	});

	var getData = function () {
		return $("#divform").ligerForm().getData();
	}
</script>