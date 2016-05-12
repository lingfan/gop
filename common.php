<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Shanghai");
$tmpUrl = isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : '';
define('CUR_HOST_PATH', $tmpUrl);
define('CUR_URL', CUR_HOST_PATH . dirname($_SERVER['PHP_SELF']) . '/');

define('ROOT_PATH', dirname(__FILE__));
define('CONFIG_PATH', ROOT_PATH . '/data');
define('SRC_PATH', ROOT_PATH . '/src');
define('VIEW_PATH', ROOT_PATH . '/src/view');
define('LOG_PATH', ROOT_PATH . '/log');

include(SRC_PATH . '/VGPM/Lib/Loader.php');
spl_autoload_register('\\VGPM\\Lib\\Loader::autoload');
