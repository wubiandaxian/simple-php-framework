<?php

/**
 * 自动加载类
 */
class Loader
{
	
	public static function register()
	{
		spl_autoload_register("self::autoload");
	}

	public static function autoload($name)
	{
		$file = self::parseName($name);
		require $file;
	}

	public static function parseName($name)
	{
		$arr = explode('\\', $name);
		$file = LIB_PATH.'/'.$name.'/'.ucfirst($name).'.php';
		if ($arr[0] == 'lib') {
			$file = BASE_PATH.$name.'.php';
		} else if ($arr[0] == 'app') {
			$file = BASE_PATH.$name.'.php';
		} else {
			$file = LIB_PATH.'/'.$name.'/'.ucfirst($name).'.php';
		}
		return $file;
	} 
}