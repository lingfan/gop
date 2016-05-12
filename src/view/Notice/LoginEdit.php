<style>
	td {
		padding: 2px
	}
</style>

<script src="<?php echo CUR_URL; ?>/asset/laydate/laydate.js"></script>

<div id="divform">
	<span style="display: none;"><input name="id" type="hidden" class="ui-textbox"/></span>
	<table>
		<tr>
			<td>
				<label for="server_ids">服务器：</label>
			</td>
			<td>
				<input id="server_ids" name="server_ids" type="text" validate="{required:true}"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="s_time">开始时间：</label>
			</td>
			<td>
				<input id="s_time" name="s_time" type="text" class="laydate-icon"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="e_time">结束时间：</label>
			</td>
			<td>
				<input id="e_time" name="e_time" type="text" class="laydate-icon"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="content">内容：</label>
			</td>
			<td>
				<textarea id="content" name="content" class="ui-textarea"  style="width: 300px; height: 100px;" ></textarea>
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

		$("#server_ids").ligerComboBox({
			width: 300,
			url: '<?php echo '?r=Server/ComboBox&all=1'?>',
			isShowCheckBox: true,
			isMultiSelect: true,
			valueFieldID: 'server_ids_val'
		});

		$("#status").ligerRadioList({
			url: '<?php echo '?r=Index/RadioStatus'; ?>',
			width: 300,
			rowSize: 4
		});

		var start = {
			elem: '#s_time',
			format: 'YYYY/MM/DD hh:mm:ss',
			min: laydate.now(), //设定最小日期为当前日期
			max: '<?php echo date('Y-m-d H:i:s',strtotime('+1 year')); ?>', //最大日期
			istime: true,
			istoday: false,
			choose: function (datas) {
				end.min = datas; //开始日选好后，重置结束日的最小日期
				end.start = datas //将结束日的初始值设定为开始日
			}
		};
		var end = {
			elem: '#e_time',
			format: 'YYYY/MM/DD hh:mm:ss',
			min: laydate.now(),
			max: '<?php echo date('Y-m-d H:i:s',strtotime('+1 year')); ?>', //最大日期
			istime: true,
			istoday: false,
			choose: function (datas) {
				start.max = datas; //结束日选好后，重置开始日的最大日期
			}
		};
		laydate(start);
		laydate(end);

		var form = liger.get("divform");
		form.setData(<?php echo !empty($info)?json_encode($info):'{}';?>);

		$("#s_time").val('<?php echo  !empty($info['s_time'])?date('Y/m/d H:i:s',$info['s_time']):'';?>');
		$("#e_time").val('<?php echo  !empty($info['e_time'])?date('Y/m/d H:i:s',$info['e_time']):'';?>');
		$("#server_ids").ligerGetComboBoxManager().setValue('<?php echo  !empty($info['server_ids'])?$info['server_ids']:'';?>');

	});


	var getData = function () {
		var ret = $("#divform").ligerForm().getData();
		ret.s_time = $("#s_time").val();
		ret.e_time = $("#e_time").val();
		ret.server_ids_val = $("#server_ids_val").val();

		return ret;
	}
</script>