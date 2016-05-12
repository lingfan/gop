<style>
	td { padding: 2px}
</style>
<div id="divform">
	<span style="display: none;"><input  name="id" type="hidden" class="ui-textbox" /></span>
	<table>
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
				权限列表：
			</td>
			<td>
				<input id="flag" name="flag" type="hidden" class="ui-checkboxlist"/>
			</td>
		</tr>
	</table>
</div>
<script>
	$(function () {
		$("#divform").ligerForm();
		$("#flag").ligerCheckBoxList({
			url: '<?php echo '?r=index/menuList'?>',
			width: "400px"
		});
		var form = new liger.get("divform");
		form.setData(<?php echo json_encode($info);?>);
		console.log(form.getData());
	});

	var getData = function () {
		return $("#divform").ligerForm().getData();
	}
</script>