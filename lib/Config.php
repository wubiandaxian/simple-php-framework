<?php
namespace lib;
/**
 * 配置类
 */
class Config
{
	protected static $configs = [];

	public static function register()
	{
		$files = scandir(CONFIG_PATH);
		foreach ($files as $key => $value) {
			if ($value == '.' || $value == '..') {
				continue;
			}
			$config = include CONFIG_PATH.$value;

			if (is_array($config)) {
				self::$configs = array_merge(self::$configs, $config);
			}
		}
	}

	public static function get($key='')
	{
		if ($key) {
			if (isset(self::$configs[$key])) {
				return self::$configs[$key];
			} else {
				return '';
			}
		} else {
			return self::$configs;
		}
	}


	public static function set($key, $value)
	{
		if (!$key) {
			throw new Exception("Key can not be empty", 1);
		}

		if (isset(self::$configs[$key])) {
			self::$configs[$key] = $value;
			return true;
		} 
		return false;
	}
}