<?php

class User {

	private static $faculties;
	private static $degreeTypes;

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
		$this->isAdmin = $isAdmin ? 1 : 0;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->phoneNumber = $phoneNumber;
		$this->gradYear = $gradYear;
		$this->facultyID = $facultyID;
		$this->degreeTypeID = $degreeTypeID;
		$this->gender = $gender;
	}

	private static function withDatabaseRecord(array $row) {
		$temp = new self($row["is_admin"], $row["first_name"], $row["last_name"], $row["email"], $row["phone_number"], $row["grad_year"], $row["faculty_id"], $row["degree_type_id"], $row["gender"]);
		$temp->setID($row["id"]);
		return $temp;
	}

	public static function withID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("User::withID expected integer ID, got " . gettype($id) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
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

	public static function getAll() {
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->query("SELECT * FROM users");
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

	public function insert() {
		// TODO
	}

	public function update() {
		// TODO
	}

	public function delete() {
		// TODO
	}

	// getters

	public function getID() {
		return $this->id;
	}

	public function getAdminStatus() {
		return ($this->isAdmin) ? true : false;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function getFullName() {
		return $this->firstName . " " . $this->lastName;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPhoneNumber() {
		return $this->phoneNumber;
	}

	public function getGradYear() {
		return $this->gradYear;
	}

	public function getFacultyID() {
		return $this->facultyID;
	}

	public function getFacultyName() {
		return self::getFaculties()[$this->facultyID];
	}

	public function getDegreeTypeID() {
		return $this->degreeTypeID;
	}

	public function getDegreeTypeName() {
		return self::getDegreeTypes()[$this->degreeTypeID];
	}

	public function getGender() {
		return $this->gender;
	}

	// setters

	private function setID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->id = $id;
	}

	public function setAdminStatus($bool) {
		$this->isAdmin = ($bool) ? 1 : 0;
	}

	public function setFirstName($name) {
		if (!Validate::name($name)) {
			throw new InvalidArgumentException("Invalid name supplied to setFirstName.");
		}
		$this->firstName = $name;
	}

	public function setLastName($name) {
		if (!Validate::name($name)) {
			throw new InvalidArgumentException("Invalid name supplied to setLastName.");
		}
		$this->lastName = $name;
	}

	public function setEmail($email) {
		if (!Validate::email($email)) {
			throw new InvalidArgumentException("Invalid email address supplied to setEmail.");
		}
		$this->email = $email;
	}

	public function setPhoneNumber($phone) {
		if (!Validate::phone($phone)) {
			throw new InvalidArgumentException("Invalid phone number supplied to setPhoneNumber.");
		}
		$this->phoneNumber = $phone;
	}

	public function setGradYear($year) {
		if (!Validate::int($year)) {
			throw new InvalidArgumentException("setGradYear expected integer year, got " . gettype($year) . " instead.");
		}
		$this->gradYear = $year;
	}

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

	public function setGender($gender) {
		if (!Validate::plainText($gender)) {
			throw new InvalidArgumentException("Invalid value supplied to setGender.");
		}
		$this->gender = $gender;
	}

}