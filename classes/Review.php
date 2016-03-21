<?php

class Review {

	private $consumerID;
	private $propertyID;
	private $rating;
	private $comment;
	private $reply;

	// constructors

	public function __construct($consumerID, $propertyID, $rating, $comment, $reply) {
		$this->setConsumerID($consumerID);
		$this->setPropertyID($propertyID);
		$this->setRating($rating);
		$this->setComment($comment);
		$this->setReply($reply);
	}

	private static function withDatabaseRecord(array $row) {
		return new self($row["consumer_id"], $row["property_id"], $row["rating"], $row["comment"], $row["reply"]);
	}

	/**
	 * @param int $consumerID
	 * @param int $propertyID
	 *
	 * @return Review
	 */
	public static function getSingle($consumerID, $propertyID) {
		if (!Validate::int($consumerID)) {
			throw new InvalidArgumentException("Review::getSingle expected integer consumer ID, got " . gettype($consumerID) . " instead.");
		}
		if (!Validate::int($propertyID)) {
			throw new InvalidArgumentException("Review::getSingle expected integer property ID, got " . gettype($propertyID) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM reviews WHERE consumer_id = :consumer_id AND property_id = :property_id");
			$stmt->bindParam(":consumer_id", $consumerID);
			$stmt->bindParam(":property_id", $propertyID);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($result === false) {
				throw new OutOfBoundsException("Nonexistent review identifier supplied to Review::getSingle.");
			}
			return self::withDatabaseRecord($result);
		} catch (PDOException $e) {
			throw new OutOfBoundsException("Invalid review identifier supplied to Review::getSingle.");
		}
	}

	/**
	 * @param int $propertyID
	 *
	 * @return Review[]
	 * @throws ErrorException
	 */
	public static function getAllForProperty($propertyID) {
		if (!Validate::int($propertyID)) {
			throw new InvalidArgumentException("Review::getAllForProperty expected integer property ID, got " . gettype($propertyID) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM reviews WHERE property_id = :property_id");
			$stmt->bindParam(":property_id", $propertyID);
			$stmt->execute();
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$reviews = [];
			foreach ($results as $row) {
				$reviews[] = self::withDatabaseRecord($row);
			}
			return $reviews;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the property's review list from the database.");
		}
	}

	/**
	 * @return Review[]
	 * @throws ErrorException
	 */
	public static function getAll() {
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->query("SELECT * FROM reviews");
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$reviews = [];
			foreach ($results as $row) {
				$reviews[] = self::withDatabaseRecord($row);
			}
			return $reviews;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the review list from the database.");
		}
	}

	// updaters

	/**
	 * @return bool
	 */
	public function insert() {
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("INSERT INTO reviews (consumer_id, property_id, rating, comment, reply) VALUES (:consumer_id, :property_id, :rating, :comment, :reply)");
			$stmt->bindParam(":consumer_id", $this->consumerID);
			$stmt->bindParam(":property_id", $this->propertyID);
			$stmt->bindParam(":rating", $this->rating);
			$stmt->bindParam(":comment", $this->comment);
			$stmt->bindParam(":reply", $this->reply);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function update() {
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("UPDATE reviews SET rating = :rating, comment = :comment, reply = :reply WHERE consumer_id = :consumer_id AND property_id = :property_id");
			$stmt->bindParam(":rating", $this->rating);
			$stmt->bindParam(":comment", $this->comment);
			$stmt->bindParam(":reply", $this->reply);
			$stmt->bindParam(":consumer_id", $this->consumerID);
			$stmt->bindParam(":property_id", $this->propertyID);
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
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("DELETE FROM reviews WHERE consumer_id = :consumer_id AND property_id = :property_id");
			$stmt->bindParam(":consumer_id", $this->consumerID);
			$stmt->bindParam(":property_id", $this->propertyID);
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
	public function getConsumerID() {
		return $this->consumerID;
	}

	/**
	 * @return User
	 */
	public function getConsumer() {
		return User::withID($this->consumerID);
	}

	/**
	 * @return int
	 */
	public function getPropertyID() {
		return $this->propertyID;
	}

	/**
	 * @return RentalProperty
	 */
	public function getProperty() {
		return RentalProperty::withID($this->propertyID);
	}

	/**
	 * @return int
	 */
	public function getRating() {
		return $this->rating;
	}

	/**
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @return string
	 */
	public function getReply() {
		return $this->reply;
	}

	// setters

	/**
	 * @param int $id
	 */
	public function setConsumerID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setConsumerID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->consumerID = $id;
	}

	/**
	 * @param int $id
	 */
	public function setPropertyID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setPropertyID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->propertyID = $id;
	}

	/**
	 * @param int $rating
	 */
	public function setRating($rating) {
		if (!Validate::int($rating)) {
			throw new InvalidArgumentException("setRating expected integer, got " . gettype($rating) . " instead.");
		}
		$rating = (int) $rating;
		$this->rating = $rating;
	}

	/**
	 * @param string $text
	 */
	public function setComment($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setComment.");
		}
		$this->comment = $text;
	}

	/**
	 * @param string $text
	 */
	public function setReply($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setReply.");
		}
		$this->reply = $text;
	}

}