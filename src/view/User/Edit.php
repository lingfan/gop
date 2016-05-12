<?php
unset($info['password']);
?>
<div id="divform" class="liger-form">
	<div class="fields">
		<input data-type="hidden" data-label="id" data-name="id"/>
		<input data-type="text" data-label="登录名称" data-name="username" validate="{required:true}"/>
		<input data-type="password" data-label="登录密码" data-name="password"/>
		<input data-type="text" data-label="显示名称" data-name="nickname" validate="{required:true}"/>
		<div id="consumer_ids" data-type="select" data-label="运营商" data-name="consumer_ids">
			<input class="editor" validate="{required:true}"/>
		</div>
		<div id="group_id" data-type="select" data-label="用户权限组" data-name="group_id">
			<input class="editor" validate="{required:true}"/>
		</div>


	</div>

</div>
<script>

	$(function () {
		var consumer_list = <?php echo !empty($consumer_list)?json_encode($consumer_list):'{}';?>;
		liger.get("consumer_ids").setData(consumer_list);

		var data = <?php echo !empty($group_list)?json_encode($group_list):'{}';?>;
		liger.get("group_id").setData(data);

		var form = liger.get("divform");
		form.setData(<?php echo !empty($info)?json_encode($info):'{}';?>);

	});

	var getData = function () {
		return $("#divform").ligerForm().getData();
	}
</script>