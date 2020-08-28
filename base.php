<?php
if (!defined('SPF')) {
	$html = file_get_contents('./view/404.html');
	echo $html;
	exit;
}

const BASE_PATH = __dir__.DIRECTORY_SEPARATOR;
const LIB_PATH = __dir__.DIRECTORY_SEPARATOR."lib".DIRECTORY_SEPARATOR;
const CONFIG_PATH = __dir__.DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR;
const COMMON_PATH = __dir__.DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR;
const VERSION = '0.0.1';

// 引入公众函数
if (is_file(COMMON_PATH.'functions.php')) {
	require COMMON_PATH.'functions.php';
}




// 注册自动加载
require LIB_PATH."Loader.php";
Loader::register();

// 注册配置文件加载
\lib\Config::register();

