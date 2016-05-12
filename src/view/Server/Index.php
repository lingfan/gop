<?php
$listUrl = CUR_URL . '?r=Server/List';
$editUrl = CUR_URL . '?r=Server/Edit&id=';
$delUrl  = CUR_URL . '?r=Server/Del&id=';

?>


<script type="text/javascript">
	var grid = null;
	$(function () {
		listgrid = $("#maingrid").ligerGrid({
			toolbar: listToolbar(),
			columns: [
				{display: '编号', name: 'no',width:"60"},
				{display: '地址', name: 'host',width:"180"},
				{display: '端口', name: 'port',width:"80"},
				{display: '名称', name: 'name',width:"120"},
				{display: '状态', name: 'status',width:"80"}
			],
			pageSize: 20,
			url: '<?php echo $listUrl;?>',
			width: '100%',
			height: '100%'

		});

		function listToolbar() {
			var items = [];
			items.push({text: '增加', click: grid_add, icon: "add"});
			items.push({text: '修改', click: grid_edit, icon: "modify"});
			items.push({text: '删除', click: grid_del, icon: "delete"});
			return {items: items};

			function grid_add() {
				f_openWindow('<?php echo $editUrl; ?>', '添加', 400, 300);
			}

			function grid_edit() {
				var row = listgrid.getSelected();
				if (!row) {
					$.ligerDialog.warn('请选择行');
					return;
				}
				f_openWindow('<?php echo $editUrl; ?>' + row.id, '编辑', 400, 300);
			}

			function grid_del() {
				var row = listgrid.getSelected();
				if (!row) {
					$.ligerDialog.warn('请选择行');
					return;
				}

				$.ligerDialog.confirm("确认删除记录?", '删除', function (yes) {
					if (yes) {
						$.ligerDialog.waitting("删除中...");
						f_post('<?php echo $delUrl; ?>' + row.id, '');
						$.ligerDialog.closeWaitting();
					}
				});

			}

			function f_openWindow(url, title, width, height) {
				return $.ligerDialog.open({
					width: width,
					height: height,
					title: title,
					url: url,
					buttons: [
						{text: '关闭', onclick: f_cancel},
						{text: '确定', onclick: f_ok, cls: 'l-dialog-btn-highlight'}
					],
					isResize: true
				});
			}

			function f_cancel(item, dialog) {
				dialog.close();
			}

			function f_ok(item, dialog) {
				var data = dialog.frame.getData();
				dialog.close();
				$.ligerDialog.waitting("提交中...");
				f_post('<?php echo $editUrl; ?>', data);
				$.ligerDialog.closeWaitting();
			}

			function f_post(url, data) {
				$.post(url, data, function (ret) {
					$.ligerDialog.closeWaitting();
					console.log(ret);
					if (ret.code == 0) {
						var tip = $.ligerDialog.tip({content: ret.msg});
						listgrid.loadData();
						setTimeout(function () {
							tip.close()
						}, 1000);
					} else {
						$.ligerDialog.warn(ret.msg);
					}
				});
			}
		}

		$("#pageloading").hide();


	});

</script>


<div id="maingrid" style="margin:0; padding:0"></div>


<div style="display:none;">
	<!-- g data total ttt -->

</div>
