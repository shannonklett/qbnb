<?php

class User {

	private static $faculties;
	private static $degreeTypes;

	/**
	 * @return string[]
	 */
	public static function getFaculties() {
		if (is_null(self::$faculties)) {
			self::$faculties = [];
			$pdo = DB::getHandle();
			$stmt = $pdo->query("SELECT id, faculty_name FROM faculties");
			$results = $stmt->fetchAll();
			if ($results !== false) {
				foreach ($results as $row) {
					self::$faculties[$row["id"]] = $row["faculty_name"];
				}
			}
		}
		return self::$faculties;
	}

	/**
	 * @return string[]
	 */
	public static function getDegreeTypes() {
		if (is_null(self::$degreeTypes)) {
			self::$degreeTypes = [];
			$pdo = DB::getHandle();
			$stmt = $pdo->query("SELECT id, degree_type_name FROM degree_types");
			$results = $stmt->fetchAll();
			if ($results !== false) {
				foreach ($results as $row) {
					self::$degreeTypes[$row["id"]] = $row["degree_type_name"];
				}
			}
		}
		return self::$degreeTypes;
	}

	private static $currentUser = NULL;

	private $id;            // int(11)
	private $isAdmin;       // tinyint(1)
	private $firstName;     // varchar(50)
	private $lastName;      // varchar(50)
	private $email;         // varchar(100)
	private $phoneNumber;   // varchar(30)
	private $gradYear;      // int(4)
	private $facultyID;     // int(2)
	private $degreeTypeID;  // int(2)
	private $gender;        // varchar(255)

	// constructors

	private function __construct($isAdmin, $firstName, $lastName, $email, $phoneNumber, $gradYear, $facultyID, $degreeTypeID, $gender) {
		$this->isAdmin = $isAdmin;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->phoneNumber = $phoneNumber;
		$this->gradYear = $gradYear;
		$this->facultyID = $facultyID;
		$this->degreeTypeID = $degreeTypeID;
		$this->gender = $gender;
	}

	/**
	 * @return null|User
	 */
	public static function current() {
		if (is_null(self::$currentUser)) {
			Session::start();
			if ($_SESSION["user_id"]) {
				self::$currentUser = self::withID($_SESSION["user_id"]);
			}
		}
		return self::$currentUser;
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $phoneNumber
	 * @param int    $gradYear
	 * @param int    $facultyID
	 * @param int    $degreeTypeID
	 * @param string $gender
	 * @param bool   $isAdmin
	 *
	 * @return bool|User
	 */
	public static function create($email, $password, $firstName, $lastName, $phoneNumber, $gradYear, $facultyID, $degreeTypeID, $gender, $isAdmin = false) {
		if (!Validate::email($email)) {
			throw new InvalidArgumentException("Invalid email address supplied to User::create.");
		}
		if (!Validate::name($firstName)) {
			throw new InvalidArgumentException("Invalid first name supplied to User::create.");
		}
		if (!Validate::name($lastName)) {
			throw new InvalidArgumentException("Invalid last name supplied to User::create.");
		}
		if (!Validate::phone($phoneNumber)) {
			throw new InvalidArgumentException("Invalid phone number supplied to User::create.");
		}
		if (!Validate::int($gradYear)) {
			throw new InvalidArgumentException("Invalid grad year supplied to User::create.");
		}
		$gradYear = (int) $gradYear;
		if (!Validate::int($facultyID)) {
			throw new InvalidArgumentException("Invalid faculty ID supplied to User::create.");
		}
		$facultyID = (int) $facultyID;
		if (!Validate::int($degreeTypeID)) {
			throw new InvalidArgumentException("Invalid last name supplied to User::create.");
		}
		$degreeTypeID = (int) $degreeTypeID;
		if (!Validate::plainText($gender)) {
			throw new InvalidArgumentException("Invalid gender text supplied to User::create.");
		}
		$isAdmin = ($isAdmin) ? 1 : 0;
		$hashPass = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);

		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("INSERT INTO users (id, is_admin, first_name, last_name, email, password, phone_number, grad_year, faculty_id, degree_type_id, gender) VALUES (NULL, :is_admin, :first_name, :last_name, :email, :password, :phone_number, :grad_year, :faculty_id, :degree_type_id, :gender)");
			$stmt->bindParam(":is_admin", $isAdmin);
			$stmt->bindParam(":first_name", $firstName);
			$stmt->bindParam(":last_name", $lastName);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":password", $hashPass);
			$stmt->bindParam(":phone_number", $phoneNumber);
			$stmt->bindParam(":grad_year", $gradYear);
			$stmt->bindParam(":faculty_id", $facultyID);
			$stmt->bindParam(":degree_type_id", $degreeTypeID);
			$stmt->bindParam(":gender", $gender);
			$stmt->execute();
			return self::withID($pdo->lastInsertId());
		} catch (PDOException $e) {
			return false;
		}
	}

	private static function withDatabaseRecord(array $row) {
		$temp = new self($row["is_admin"], $row["first_name"], $row["last_name"], $row["email"], $row["phone_number"], $row["grad_year"], $row["faculty_id"], $row["degree_type_id"], $row["gender"]);
		$temp->setID($row["id"]);
		return $temp;
	}

	/**
	 * @param int $id
	 *
	 * @return User
	 */
	public static function withID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("User::withID expected integer ID, got " . gettype($id) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT id, is_admin, first_name, last_name, email, phone_number, grad_year, faculty_id, degree_type_id, gender FROM users WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($result === false) {
				throw new OutOfBoundsException("Nonexistent user ID supplied to User::withID.");
			}
			return self::withDatabaseRecord($result);
		} catch (PDOException $e) {
			throw new OutOfBoundsException("Invalid user ID supplied to User::withID.");
		}
	}

	/**
	 * @param string $email
	 *
	 * @return User
	 */
	public static function withEmail($email) {
		if (!Validate::email($email)) {
			throw new InvalidArgumentException("Invalid email address supplied to User::withEmail.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT id, is_admin, first_name, last_name, email, phone_number, grad_year, faculty_id, degree_type_id, gender FROM users WHERE email = :email");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($result === false) {
				throw new OutOfBoundsException("Nonexistent user email address supplied to User::withEmail.");
			}
			return self::withDatabaseRecord($result);
		} catch (PDOException $e) {
			throw new OutOfBoundsException("Invalid user email address supplied to User::withEmail.");
		}
	}

	/**
	 * @return User[]
	 * @throws ErrorException
	 */
	public static function getAll() {
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->query("SELECT id, is_admin, first_name, last_name, email, phone_number, grad_year, faculty_id, degree_type_id, gender FROM users");
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$users = [];
			foreach ($results as $row) {
				$users[] = self::withDatabaseRecord($row);
			}
			return $users;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the user list from the database.");
		}
	}

	// updaters

	/**
	 * @return bool
	 */
	public function update() {
		if (!$this->id) {
			throw new BadMethodCallException("Attempt to update nonexistent record.");
		}
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("UPDATE users SET is_admin = :is_admin, first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, grad_year = :grad_year, faculty_id = :faculty_id, degree_type_id = :degree_type_id, gender = :gender WHERE id = :id");
			$stmt->bindParam(":is_admin", $isAdmin);
			$stmt->bindParam(":first_name", $firstName);
			$stmt->bindParam(":last_name", $lastName);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":phone_number", $phoneNumber);
			$stmt->bindParam(":grad_year", $gradYear);
			$stmt->bindParam(":faculty_id", $facultyID);
			$stmt->bindParam(":degree_type_id", $degreeTypeID);
			$stmt->bindParam(":gender", $gender);
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function delete() {
		if (!$this->id) {
			throw new BadMethodCallException("Attempt to delete nonexistent record.");
		}
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	// getters

	/**
	 * @return int
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function isAdmin() {
		return ($this->isAdmin) ? true : false;
	}

	/**
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getFullName() {
		return $this->firstName . " " . $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}

	/**
	 * @return int
	 */
	public function getGradYear() {
		return $this->gradYear;
	}

	/**
	 * @return int
	 */
	public function getFacultyID() {
		return $this->facultyID;
	}

	/**
	 * @return string
	 */
	public function getFacultyName() {
		return self::getFaculties()[$this->facultyID];
	}

	/**
	 * @return int
	 */
	public function getDegreeTypeID() {
		return $this->degreeTypeID;
	}

	/**
	 * @return string
	 */
	public function getDegreeTypeName() {
		return self::getDegreeTypes()[$this->degreeTypeID];
	}

	/**
	 * @return string
	 */
	public function getGender() {
		return $this->gender;
	}

	// setters

	/**
	 * @param int $id
	 */
	private function setID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->id = $id;
	}

	/**
	 * @param bool $isAdmin
	 */
	public function setAdminStatus($isAdmin) {
		$this->isAdmin = ($isAdmin) ? 1 : 0;
	}

	/**
	 * @param string $name
	 */
	public function setFirstName($name) {
		if (!Validate::name($name)) {
			throw new InvalidArgumentException("Invalid name supplied to setFirstName.");
		}
		$this->firstName = $name;
	}

	/**
	 * @param string $name
	 */
	public function setLastName($name) {
		if (!Validate::name($name)) {
			throw new InvalidArgumentException("Invalid name supplied to setLastName.");
		}
		$this->lastName = $name;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email) {
		if ($email == $this->email) {
			return;
		}
		if (!Validate::email($email)) {
			throw new InvalidArgumentException("Invalid email address supplied to setEmail.");
		}
		if (!User::emailAvailable($email)) {
			throw new InvalidArgumentException("The email address supplied to setEmail is already taken.");
		}
		$this->email = $email;
	}

	/**
	 * @param string $email
	 *
	 * @return bool
	 */
	public static function emailAvailable($email) {
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("SELECT 1 FROM users WHERE email = :email");
			$stmt->bindParam(":email", $email);
			$stmt->execute();
			$result = $stmt->fetch();
			return ($result === false);
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * @param string $password
	 *
	 * @return bool
	 */
	public function setPassword($password) {
		$hashPass = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
			$stmt->bindParam(":password", $hashPass);
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * @param string $phone
	 */
	public function setPhoneNumber($phone) {
		if (!Validate::phone($phone)) {
			throw new InvalidArgumentException("Invalid phone number supplied to setPhoneNumber.");
		}
		$this->phoneNumber = $phone;
	}

	/**
	 * @param int $year
	 */
	public function setGradYear($year) {
		if (!Validate::int($year)) {
			throw new InvalidArgumentException("setGradYear expected integer year, got " . gettype($year) . " instead.");
		}
		$this->gradYear = $year;
	}

	/**
	 * @param int $id
	 */
	public function setFacultyID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setFacultyID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		if (!array_key_exists($id, self::$faculties)) {
			throw new InvalidArgumentException("Nonexistent ID supplied to setFacultyID.");
		}
		$this->facultyID = $id;
	}

	/**
	 * @param int $id
	 */
	public function setDegreeTypeID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setDegreeTypeID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		if (!array_key_exists($id, self::$degreeTypes)) {
			throw new InvalidArgumentException("Nonexistent ID supplied to setDegreeTypeID.");
		}
		$this->degreeTypeID = $id;
	}

	/**
	 * @param string $gender
	 */
	public function setGender($gender) {
		if (!Validate::plainText($gender)) {
			throw new InvalidArgumentException("Invalid value supplied to setGender.");
		}
		$this->gender = $gender;
	}

}