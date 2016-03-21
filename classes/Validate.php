<?php

class Validate {

	private function __construct() {}
	private function __clone() {}

	public static function int($value) {
		if (is_int($value)) {
			return true;
		}
		if (is_string($value) && ctype_digit($value)) {
			return true;
		}
		return false;
	}

	public static function plainText($string, $allowEmpty = false) {
		if (!isset($string) || is_null($string)) {
			return false;
		}
		if (!is_string($string)) {
			return false;
		}
		if (trim($string) === "") {
			return ($allowEmpty) ? true : false;
		}
		return ($string === strip_tags($string));
	}

	public static function HTML($string, $allowEmpty = false) {
		if (!isset($string) || is_null($string)) {
			return false;
		}
		if (!is_string($string)) {
			return false;
		}
		if (trim($string) === "") {
			return ($allowEmpty) ? true : false;
		}
		if (stripos($string, "<?php") !== false || stripos($string, "?>" !== false)) {
			return false;
		}
		return true;
	}

	public static function name($name) {
		if (empty($name) || is_null($name)) {
			return false;
		}
		if (!is_string($name)) {
			return false;
		}
		if (trim($name) === "") {
			return false;
		}
		if ($name !== strip_tags($name)) {
			return false;
		}
		return (preg_match("/^[[:alpha:] '-]+$/", $name));
	}

	public static function email($email) {
		if (empty($email) || is_null($email)) {
			return false;
		}
		if (!is_string($email)) {
			return false;
		}
		if (trim($email) === "") {
			return false;
		}
		if ($email !== strip_tags($email)) {
			return false;
		}
		return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
	}

	public static function url($url) {
		if (empty($url) || is_null($url)) {
			return false;
		}
		if (!is_string($url)) {
			return false;
		}
		if (trim($url) === "") {
			return false;
		}
		if ($url !== strip_tags($url)) {
			return false;
		}
		return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
	}

	public static function phone($digits) {
		if (empty($digits) || is_null($digits)) {
			return false;
		}
		if (!is_string($digits)) {
			return false;
		}
		if (trim($digits) === "") {
			return false;
		}
		if ($digits !== strip_tags($digits)) {
			return false;
		}
		$digits = preg_replace("/[^0-9\\+]/i", "", $digits);
		return (preg_match("/^\\+?[0-9]{10,11}$/", $digits) === 1);
	}

}