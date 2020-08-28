<?php
namespace lib;

use lib\Dispatch;

class App
{
	private static $response;
	private static $instance;
	private function __construct() { }
	private function __clone() { }

	public static function getInstance()
	{
		if (! self::$instance instanceof self) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public  function run()
	{
		$dispatch = new Dispatch();
		$module = $dispatch->getModule();
		$controller = $dispatch->getController();
		$method = $dispatch->getMethod();

		$class = '\\app\\'.$module.'\\controller\\'.$controller;
		self::$response = call_user_func(array(new $class(), $method));
		return self::$instance;
	}

	public  function send()
	{
		echo self::$response;
	}
}