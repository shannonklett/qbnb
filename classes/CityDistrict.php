<?php

class CityDistrict {

	private $id;
	private $districtName;
	private $pointsOfInterest;

	// constructors

	public function __construct($id, $districtName, $pointsOfInterest) {
		$this->setID($id);
		$this->setName($districtName);
		$this->setPointsOfInterest($pointsOfInterest);
	}

	// getters

	/**
	 * @return int
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->districtName;
	}

	/**
	 * @return string
	 */
	public function getPointsOfInterest() {
		return $this->pointsOfInterest;
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
	 * @param string $districtName
	 */
	public function setName($districtName) {
		if (!Validate::plainText($districtName)) {
			throw new InvalidArgumentException("Invalid district name supplied to setName.");
		}
		$this->districtName = $districtName;
	}

	/**
	 * @param string $text
	 */
	public function setPointsOfInterest($text) {
		if (!Validate::plainText($text)) {
			throw new InvalidArgumentException("Invalid text supplied to setPointsOfInterest.");
		}
		$this->pointsOfInterest = $text;
	}

}