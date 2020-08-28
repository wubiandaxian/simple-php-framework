<?php
namespace lib;

class Dispatch
{
	private $module = 'index';
	private $controller = 'Index';
	private $method = 'index';

	public function getModule()
	{
		return $this->module;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getMethod()
	{
		return $this->method;
	}

}