<?php

class DB {

	const DB_HOST = "localhost:8889";
	const DB_NAME = "CISC332Project";
	const DB_USER = "root";
	const DB_PASS = "root";

	private static $connection = NULL;

	private function __construct() {}
	private function __clone() {}

	/**
	 * @return PDO
	 */
	public static function getHandle() {
		if (is_null(self::$connection)) {
			self::open();
		}
		return self::$connection;
	}

	private static function open() {
		try {
			self::$connection = new PDO("mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8", self::DB_USER, self::DB_PASS);
			self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			throw new RuntimeException("Unable to initiate database connection.");
		}
	}
	
}
