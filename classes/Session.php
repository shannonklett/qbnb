<?php

class Session {

	private static $sessionOpen = false;

	private function __construct() {}
	private function __clone() {}

	/**
	 * Start the session.
	 * This can be called manually to start the session before any HTTP headers are sent.
	 */
	public static function start() {
		if (self::$sessionOpen) {
			return;
		}
		session_start();
		self::$sessionOpen = true;
		if (!isset($_SESSION["user_id"])) {
			$_SESSION["user_id"] = 0;
		}
	}

	private static function end() {
		self::start();
		session_unset();
		session_destroy();
		self::$sessionOpen = false;
	}

	/**
	 * Determine if the user is currently logged in.
	 *
	 * @return bool
	 */
	public static function authenticate() {
		self::start();
		if ($_SESSION["user_id"]) {
			return true;
		}
		return false;
	}

	/**
	 * Log the current user in with their email and password.
	 *
	 * @param string $email
	 * @param string $password
	 *
	 * @return bool
	 */
	public static function login($email, $password) {
		if (!Validate::email($email)) {
			throw new InvalidArgumentException("Invalid email address supplied to Session::login.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			$user = $stmt->fetch();
			if ($user === false) {
				return false;
			}
		} catch (PDOException $e) {
			return false;
		}
		if (!password_verify($password, $user["password"])) {
			return false;
		}
		self::start();
		$_SESSION["user_id"] = $user["id"];
		return true;
	}

	/**
	 * Log the current user out.
	 * This will work if called when the user is not logged in.
	 */
	public static function logout() {
		self::end();
		header('Location: ./');
		exit();
	}

	/**
	 * Redirect to a new location and end execution of the script (i.e. stop processing past the redirect).
	 * This must be called before any HTTP headers are sent.
	 *
	 * @param string $location
	 */
	public static function redirect($location) {
		header("Location: " . $location);
		die();
	}

}
