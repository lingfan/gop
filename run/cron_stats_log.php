<?php
include(dirname(dirname(__FILE__)).'/common.php');
$app = new \VGPM\Lib\Controller('Cron');
$app->cli('StatsLog', 'Run');