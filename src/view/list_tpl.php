<?php
$width  = !empty($width) ? $width : 450;
$height = !empty($height) ? $height : 400;
?>

<script type="text/javascript">
	var grid = null;
	$(function () {
		listgrid = $("#maingrid").ligerGrid({
			columns: <?php echo json_encode($fields,JSON_UNESCAPED_UNICODE); ?>,
			pageSize: 20,
			url: '<?php echo $listUrl;?>',
			width: '100%',
			height: '100%',
			enabledEdit: true
		});


		$("#toptoolbar").ligerToolBar(
			{
				items: [
					<?php if (!empty($editUrl)):
						echo "{text: '增加', icon: 'add', click: grid_add},{text: '修改', icon: 'modify', click: grid_edit},";

				    endif;?>
					<?php if (!empty($delUrl)):
						echo "{text: '删除', icon: 'delete', click: grid_del}";
					endif;?>
				]
			}
		);


		function grid_add() {
			f_openWindow('<?php echo $editUrl; ?>', '添加', <?php echo $width; ?>, <?php echo $height; ?>);
		}

		function grid_edit() {
			var row = listgrid.getSelected();
			if (!row) {
				$.ligerDialog.warn('请选择行');
				return;
			}
			f_openWindow('<?php echo $editUrl; ?>' + row.id, '编辑', <?php echo $width; ?>, <?php echo $height; ?>);
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


		$("#pageloading").hide();


	});

</script>





