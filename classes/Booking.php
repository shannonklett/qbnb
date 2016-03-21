<?php

class Booking {

	private static $statusTypes;

	public static function getStatusTypes() {
		if (is_null(self::$statusTypes)) {
			self::$statusTypes = [];
			$pdo = DB::getHandle();
			$stmt = $pdo->query("SELECT id, status_type_name FROM booking_status_types");
			$results = $stmt->fetchAll();
			if ($results !== false) {
				foreach ($results as $row) {
					self::$statusTypes[$row["id"]] = $row["status_type_name"];
				}
			}
		}
		return self::$statusTypes;
	}

	private $id;
	private $consumerID;
	private $propertyID;
	private $startDate;
	private $endDate;
	private $statusID;

	// constructors

	public function __construct($consumerID, $propertyID, DateTime $startDate, DateTime $endDate, $statusID) {
		$this->setConsumerID($consumerID);
		$this->setPropertyID($propertyID);
		$this->setStartDate($startDate);
		$this->setEndDate($endDate);
		$this->setStatusID($statusID);
	}

	private static function withDatabaseRecord(array $row) {
		$startDate = DateTime::createFromFormat(Format::MYSQL_DATE_FORMAT, $row["start_date"]);
		$endDate   = DateTime::createFromFormat(Format::MYSQL_DATE_FORMAT, $row["end_date"]);
		$temp = new self($row["consumer_id"], $row["property_id"], $startDate, $endDate, $row["status_id"]);
		$temp->setID($row["id"]);
		return $temp;
	}

	public static function withID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("Booking::withID expected integer ID, got " . gettype($id) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($result === false) {
				throw new OutOfBoundsException("Nonexistent booking ID supplied to Booking::withID.");
			}
			return self::withDatabaseRecord($result);
		} catch (PDOException $e) {
			throw new OutOfBoundsException("Invalid booking ID supplied to Booking::withID.");
		}
	}

	public static function getAllForConsumer($consumerID) {
		if (!Validate::int($consumerID)) {
			throw new InvalidArgumentException("Booking::getAllForConsumer expected integer consumer ID, got " . gettype($consumerID) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM bookings WHERE consumer_id = :consumer_id");
			$stmt->bindParam(":consumer_id", $consumerID);
			$stmt->execute();
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$bookings = [];
			foreach ($results as $row) {
				$bookings[] = self::withDatabaseRecord($row);
			}
			return $bookings;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the consumer's booking list from the database.");
		}
	}

	public static function getAllForProperty($propertyID) {
		if (!Validate::int($propertyID)) {
			throw new InvalidArgumentException("Booking::getAllForProperty expected integer property ID, got " . gettype($propertyID) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM bookings WHERE property_id = :property_id");
			$stmt->bindParam(":property_id", $propertyID);
			$stmt->execute();
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$bookings = [];
			foreach ($results as $row) {
				$bookings[] = self::withDatabaseRecord($row);
			}
			return $bookings;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the property's booking list from the database.");
		}
	}

	public static function getAll() {
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->query("SELECT * FROM bookings");
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$bookings = [];
			foreach ($results as $row) {
				$bookings[] = self::withDatabaseRecord($row);
			}
			return $bookings;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the booking list from the database.");
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

	public function getConsumerID() {
		return $this->consumerID;
	}

	public function getConsumer() {
		return User::withID($this->consumerID);
	}

	public function getRentalPropertyID() {
		return $this->propertyID;
	}

	public function getRentalProperty() {
		return RentalProperty::withID($this->propertyID);
	}

	public function getStartDate() {
		return clone $this->startDate;
	}

	public function getEndDate() {
		return clone $this->endDate;
	}

	public function getStatusID() {
		return $this->statusID;
	}

	public function getStatus() {
		return self::getStatusTypes()[$this->statusID];
	}

	// setters

	private function setID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->id = $id;
	}

	public function setConsumerID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setConsumerID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->consumerID = $id;
	}

	public function setPropertyID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setPropertyID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->propertyID = $id;
	}

	public function setStartDate(DateTime $start) {
		$this->startDate = clone $start;
		$this->startDate->setTime(0, 0, 0);
	}

	public function setEndDate(DateTime $end) {
		$this->endDate = clone $end;
		$this->endDate->setTime(0, 0, 0);
	}

	public function setStatusID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setStatusID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->statusID = $id;
	}

}