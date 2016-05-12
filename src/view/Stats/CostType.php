<?php
$listUrl = CUR_URL . '?r=Stats/CostTypeList';
$editUrl = '';
$delUrl  = '';

$fields = [
	['display' => '消费类型', 'name' => 'type'],
	['display' => '金额', 'name' => 'num'],
	['display' => '占比', 'name' => 'rate'],
];

?>

<script>
	$(function () {
		$("#search_form").ligerForm();
		$("#searchbtn").ligerButton({
			click: function () {
				if (!listgrid) return;
				var sdate = $("#sdate").val();
				var edate = $("#edate").val();
				var server_id = $("#server_id").val();
				var consumer_id = $("#consumer_id").val();
				listgrid.setOptions({
					parms: [
						{name: 'sdate', value: sdate},
						{name: 'edate', value: edate},
						{name: 'server_id', value: server_id},
						{name: 'consumer_id', value: consumer_id}
					]
				});
				listgrid.loadData(true);
			}
		});

		$("#sdate,#edate").ligerDateEditor({showTime: true, format: "yyyy/MM/dd hh:mm", labelWidth: 60});
		$("#server_id").ligerComboBox({
			url: '<?php echo '?r=Server/ComboBox&all=1'?>',
			width: 120
		});
		$("#consumer_id").ligerComboBox({
			url: '<?php echo '?r=Consumer/ComboBox&all=1'?>',
			width: 120
		});

	});

</script>
<div id="search_form">

	<li class="l-panel-search-item">
		时间：
	</li>
	<li class="l-panel-search-item">
		<input type="text" id="sdate"/>
	</li>
	<li class="l-panel-search-item">
		至
	</li>
	<li class="l-panel-search-item">
		<input type="text" id="edate"/>
	</li>
	<li class="l-panel-search-item">
		服务器：
	</li>
	<li class="l-panel-search-item">
		<input id="server_id" name="server_id" type="hidden" class="ui-combox"/>
	</li>
	<li class="l-panel-search-item">
		运营商：
	</li>
	<li class="l-panel-search-item">
		<input id="consumer_id" name="consumer_id" type="hidden" class="ui-combox"/>
	</li>
	<li class="l-panel-search-item">
		<div id="searchbtn" style="width:80px;">搜索</div>
	</li>
</div>


<?php
include(VIEW_PATH . '/list_tpl.php');
?>

<div id="maingrid" style="margin:0; padding:0"></div>
