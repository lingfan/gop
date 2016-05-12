<?php
$listUrl = CUR_URL . '?r=Stats/DayList';
$editUrl = '';
$delUrl  = '';

$fields = [
	['display' => '日期', 'name' => 'date'],
	['display' => '活跃用户', 'name' => 'active_user'],

	['display' => '平均在线用户', 'name' => 'online_user_avg'],
	['display' => '最大在线用户', 'name' => 'online_user_top'],

	['display' => '新增用户', 'name' => 'keep_user_new'],
	['display' => '次日留存率', 'name' => 'keep_user_1'],
	['display' => '7日留存率', 'name' => 'keep_user_7'],
	['display' => '30日留存率', 'name' => 'keep_user_30'],

	['display' => '新增付费用户', 'name' => 'pay_user_new'],
	['display' => '次日付费率', 'name' => 'pay_user_1'],
	['display' => '7日付费率', 'name' => 'pay_user_7'],
	['display' => '30日付费率', 'name' => 'pay_user_30'],


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
				listgrid.setOptions({
					parms: [
						{name: 'sdate', value: sdate},
						{name: 'edate', value: edate},
						{name: 'server_id', value: server_id}
					]
				});
				listgrid.loadData(true);
			}
		});

		$("#sdate,#edate").ligerDateEditor({ format: "yyyy/MM/dd", labelWidth: 60});
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
		<div id="searchbtn" style="width:80px;">搜索</div>
	</li>
</div>


<?php
include(VIEW_PATH . '/list_tpl.php');
?>

<div id="maingrid" style="margin:0; padding:0"></div>
