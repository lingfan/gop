<?php
include(dirname(dirname(__FILE__)).'/common.php');
$app = new \VGPM\Lib\Controller('Cron');
if ($argc < 3) {
	echo "Usage: {$argv[0]} 模块 方法";
	exit;
}

$app->cli($argv[1], $argv[2]);