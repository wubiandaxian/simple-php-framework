<?php
namespace lib;

use lib\Config;

class Db
{
	private static $host;
	private static $username;
	private static $password;
	private static $database;
	private static $charset;

	private static $instance;
	private static $connect;
	private static $table;
	private static $where;
	private static $field = '*';
	private static $limit;
	private static $lastSql;

	private function __clone()
	{

	}


	private function __construct()
	{
		self::$host = Config::get('host');
		self::$username = Config::get('username');
		self::$password = Config::get('password');
		self::$database = Config::get('database');
		self::$charset = Config::get('charset');

		$conn = new \mysqli(self::$host, self::$username, self::$password);
		if (!$conn){
			die('数据库链接失败');
		}

		$conn->query("use ".self::$database);
		$conn->set_charset(self::$charset);
		self::$connect = $conn;
	}

	public static function getInstance()
	{
		if (! self::$instance instanceof self) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function name($name)
	{
		if (!$name) {
			throw new Exception("Table name is not exist", 1);
		}
			
		self::$table = $name;

		return self::getInstance();
	}

	public static function query($sql)
	{
		if (!$sql) {
			throw new Exception("Sql is not exist", 1);
		}
		self::getInstance();
		self::$lastSql = $sql;
		$rs = self::$connect->query($sql);
		return $rs;
	}

	public function getLastSql()
	{
		return self::$lastSql;
	}


	public function find($id='')
	{

		if ($id) {
			$condition = "id = ".$id;
			self::addWhere($condition);
		} 
		self::$limit = ' limit 1';
		$sql = self::makeSql('find');
		$row = self::query($sql)->fetch_assoc();
		self::initParams();
		return $row;
	}

	public function where($value)
	{
		if (!$value) {
			return self::getInstance();
		} 

		if (is_string($value)) {
			$condition = self::$connect->real_escape_string($value);
			self::addWhere($condition);
		} else if (is_array($value)) {
			self::parseWhere($value);
		}

		return self::getInstance();
	}

	protected static function addWhere($condition)
	{
		if (!is_string($condition)) {
			throw new Exception("The where condition format is wrong", 1);
		}
		if (self::$where == '') {
			self::$where = " where ".$condition;
		} else {
			self::$where = self::$where." and ".$condition;
		}
	}
	protected static function parseWhere($array)
	{
		foreach ($array as $key => $value) {
			if (count($value) == 2) {
				$condition =  $value[0]." = ".$value[1];
				self::addWhere($condition);

			} else if (count($value) == 3) {
				switch ($value[1]) {
					default:
						$condition =  $value[0]." ".$value[1]." '".$value[2]."'";
						dump($condition);
						self::addWhere($condition);
						break;
				}
			} else {
				throw new Exception("The where condition format is wrong", 1);
			}
		}
	}

	protected static function initParams()
	{
		self::$where = '';
		self::$field = '*';
		self::$limit = '';
	}

	public function field($value='')
	{
		if (!$value) {
			return self::getInstance();
		}

		if (is_string($value)) {
			self::$field = self::$connect->real_escape_string($value);
		} else if (is_array($value)) {
			self::$field = self::$connect->real_escape_string(implode(', ', $value));
		}

		return self::getInstance();
	}

	protected static function makeSql($type)
	{
		switch ($type) {
			case 'find':
				$sql = "select ".self::$field." from ".self::$table.self::$where.self::$limit;
				break;
			default:
				# code...
				break;
		}
		return $sql;
	}

}
