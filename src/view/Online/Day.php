<?php
$listUrl = CUR_URL . '?r=Online/DayList';
$editUrl = '';
$delUrl  = '';

$fields = [
	['display' => '日期', 'name' => 'date', 'width' => 160],
	['display' => '平均在线', 'name' => 'avg', 'width' => 60],
	['display' => '最高在线', 'name' => 'max', 'width' => 60],
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
				listgrid.setOptions(
						{
							parms: [
								{name: 'sdate', value: sdate},
								{name: 'edate', value: edate},
								{name: 'server_id', value: server_id}
							]
						}
				);
				listgrid.loadData(true);
			}
		});

		$("#sdate,#edate").ligerDateEditor({format: "yyyy/MM/dd", labelWidth: 60});
		$("#server_id").ligerListBox({width: 120});
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
		<select name="server_id" id="server_id">
			<option value="0">全部</option>
			<option value="1">S11111111111111</option>
			<option value="2">S2</option>
			<option value="3">S3</option>
		</select>

	</li>

	<li class="l-panel-search-item">
		<div id="searchbtn" style="width:80px;">搜索</div>
	</li>
</div>


<?php
include(VIEW_PATH . '/list_tpl.php');
?>

<div id="maingrid" style="margin:0; padding:0;"></div>

