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

	public function getConsumerID() {
		return $this->consumerID;
	}

	public function getConsumer() {
		return User::withID($this->consumerID);
	}

	public function getPropertyID() {
		return $this->propertyID;
	}

	public function getProperty() {
		return RentalProperty::withID($this->propertyID);
	}

	public function getRating() {
		return $this->rating;
	}

	public function getComment() {
		return $this->comment;
	}

	public function getReply() {
		return $this->reply;
	}

	// setters

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

	public function setRating($rating) {
		if (!Validate::int($rating)) {
			throw new InvalidArgumentException("setRating expected integer, got " . gettype($rating) . " instead.");
		}
		$rating = (int) $rating;
		$this->rating = $rating;
	}

	public function setComment($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setComment.");
		}
		$this->comment = $text;
	}

	public function setReply($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setReply.");
		}
		$this->reply = $text;
	}

}