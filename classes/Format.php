<?php

class Format {

	private function __construct() {}
	private function __clone() {}

	const DATE_FORMAT = "n/j/Y";
	const TIME_FORMAT = "g:i A";
	const MYSQL_DATE_FORMAT = "Y-m-d";
	const MYSQL_TIMESTAMP_FORMAT = "Y-m-d H:i:s";

	public static function ordinal($int) {
		if (is_int($int) || ctype_digit($int)) {
			$mod100 = abs($int) % 100;
			$ends   = array("th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th");
			if (($mod100) > 10 && ($mod100) < 14) {
				return $int . "th";
			}
			return $int . $ends[abs($int) % 10];
		}
		throw new InvalidArgumentException("Expected integer input to format, got " . gettype($int) . " instead.");
	}

	public static function truncate($string, $maxChars = 50) {
		return (strlen($string) > $maxChars + 3) ? substr($string, 0, $maxChars) . "..." : $string;
	}

	public static function relativeTime($ts) {

		// convert the input to a UNIX timestamp
		if ($ts instanceof DateTime) {
			$ts = $ts->getTimestamp();
		} else if(!ctype_digit($ts)) {
        	$ts = strtotime($ts);
		}

		$diff = time() - $ts;

		if($diff == 0) {

        	return 'Now';

		} else if($diff > 0) {

			$day_diff = floor($diff / 86400);
			if($day_diff == 0) {
				if($diff < 60) return 'Just now';
				if($diff < 120) return '1 minute ago';
				if($diff < 3600) return floor($diff / 60) . ' minutes ago';
				if($diff < 7200) return '1 hour ago';
				if($diff < 86400) return floor($diff / 3600) . ' hours ago';
			}
			if($day_diff == 1) return 'Yesterday';
			if($day_diff < 7) return $day_diff . ' days ago';
			if($day_diff == 7) return '1 week ago';
			if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
			if($day_diff < 60) return 'Last month';

			return date('F Y', $ts);

		} else {

			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0) {
				if($diff < 120) return 'In a minute';
				if($diff < 3600) return 'In ' . floor($diff / 60) . ' minutes';
				if($diff < 7200) return 'In an hour';
				if($diff < 86400) return 'In ' . floor($diff / 3600) . ' hours';
			}
			if($day_diff == 1) return 'Tomorrow';
			if($day_diff < 4) return date('l', $ts);
			if($day_diff < 7 + (7 - date('w'))) return 'Next week';
			if(ceil($day_diff / 7) < 4) return 'In ' . ceil($day_diff / 7) . ' weeks';
        	if(date('n', $ts) == date('n') + 1) return 'Next month';

        	return date('F Y', $ts);

    	}
	}

	public static function phone($digits) {
		$plusPrefix = false;
		$onePrefix = false;
		$digits = preg_replace("/[^0-9\\+]/i", "", $digits);
		if (strlen($digits) < 10 || strlen($digits) > 12) {
			return $digits;
		}
		if ($digits[0] == "+") {
			$plusPrefix = true;
			$digits = substr($digits, 1);
		}
		if (strlen($digits) == 11 && $digits[0] == "1") {
			$onePrefix = true;
			$digits = substr($digits, 1);
		}
		$phoneStr = "(" . substr($digits, 0, 3) . ") " . substr($digits, 3, 3) . "-" . substr($digits, 6, 4);
		if ($plusPrefix) {
			$phoneStr = "+1 " . $phoneStr;
		} else if ($onePrefix) {
			$phoneStr = "1 " . $phoneStr;
		}

		return $phoneStr;
	}

	public static function tel($digits) {
		return $digits = preg_replace("/[^0-9\\+]/i", "", $digits);
	}

	public static function bytes($size, $precision = 2) {
		try {
			$size = (int) $size;
		} catch (Exception $e) {
			throw new InvalidArgumentException("Expected integer filesize, got " . gettype($size) . " instead.");
		}
		$prefixes = array("bytes", "kB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
		$magnitude = 0;
		while ($size >= 1024 || $size <= -1024) {
			$size = $size / 1024;
			$magnitude ++;
		}
		if (!array_key_exists($magnitude, $prefixes)) {
			throw new OutOfRangeException("The filesize is too large to format.");
		}
		return round($size, $precision) . " " . $prefixes[$magnitude];
	}
	
}
