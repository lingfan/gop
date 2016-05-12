<?php
$listUrl = CUR_URL . '?r=User/GroupList';
$editUrl = CUR_URL . '?r=User/GroupEdit&id=';
$delUrl  = CUR_URL . '?r=User/GroupDel&id=';



$fields = [
		['display'=>'ID','name'=>'id','width'=> 60],
		['display'=>'名称','name'=>'name','width'=> 200],
];

include(VIEW_PATH.'/list_tpl.php');
?>
<div id="toptoolbar">

</div>
<div id="maingrid" style="margin:0; padding:0"></div>


