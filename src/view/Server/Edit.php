<style>
	td { padding: 2px}
</style>
<div id="divform">
	<span style="display: none;"><input  name="id" type="hidden" class="ui-textbox" /></span>
	<table>
		<tr>
			<td>
				<label for="no">编号：</label>
			</td>
			<td>
				<input id="no" name="no" type="text" class="ui-textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="host">地址：</label>
			</td>
			<td>
				<input id="host" name="host" type="text" class="ui-textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="port">端口：</label>
			</td>
			<td>
				<input id="port" name="port" type="text" class="ui-textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="name">名称：</label>
			</td>
			<td>
				<input id="name" name="name" type="text" class="ui-textbox"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="status">状态：</label>
			</td>
			<td>
				<input id="status" name="status" type="hidden" class="ui-radiolist"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="sort">排序：</label>
			</td>
			<td>
				<input id="sort" name="sort" type="text" class="ui-textbox"/>
			</td>
		</tr>
	</table>

</div>


<script>
	$(function () {
		$("#divform").ligerForm();

		$("#status").ligerRadioList({
			url: '<?php echo '?r=Server/RadioList'; ?>',
			width:300,
			rowSize:4
		});
		//$("#sort").ligerSpinner({type: 'int' });

		var form = liger.get("divform");
		form.setData(<?php echo !empty($info)?json_encode($info):'{}';?>);
	});


	var getData = function () {
		return $("#divform").ligerForm().getData();
	}
</script>