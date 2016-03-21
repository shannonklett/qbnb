<?php

class RentalProperty {

	private static $propertyTypes;
	private static $cityDistricts;

	public static function getPropertyTypes() {
		if (is_null(self::$propertyTypes)) {
			self::$propertyTypes = [];
			$pdo = DB::getHandle();
			$stmt = $pdo->query("SELECT id, property_type_name FROM rental_property_types");
			$results = $stmt->fetchAll();
			if ($results !== false) {
				foreach ($results as $row) {
					self::$propertyTypes[$row["id"]] = $row["property_type_name"];
				}
			}
		}
		return self::$propertyTypes;
	}

	public static function getCityDistricts() {
		if (is_null(self::$cityDistricts)) {
			self::$cityDistricts = [];
			$pdo = DB::getHandle();
			$stmt = $pdo->query("SELECT id, district_name, points_of_interest FROM city_districts");
			$results = $stmt->fetchAll();
			if ($results !== false) {
				foreach ($results as $row) {
					self::$cityDistricts[$row["id"]] = new CityDistrict($row["id"], $row["district_name"], $row["points_of_interest"]);
				}
			}
		}
		return self::$cityDistricts;
	}

	private $id;
	private $name;
	private $supplierID;
	private $address;
	private $districtID;
	private $propertyTypeID;
	private $numGuests;
	private $numRooms;
	private $numBathrooms;
	private $price;
	private $description;

	private $hasAirConditioning;
	private $hasCableTV;
	private $hasLaundryMachines;
	private $hasParking;
	private $hasGym;
	private $hasInternet;
	private $petsAllowed;
	private $hasWheelchairAccess;
	private $hasPool;
	private $hasTransportAccess;
	private $hasPrivateBathroom;

	// constructors

	public function __construct($name, $supplierID, $address, $districtID, $propertyTypeID, $numGuests, $numRooms, $numBathrooms, $price, $description, array $features) {
		$this->setName($name);
		$this->setSupplierID($supplierID);
		$this->setAddress($address);
		$this->setDistrictID($districtID);
		$this->setPropertyTypeID($propertyTypeID);
		$this->setNumGuests($numGuests);
		$this->setNumRooms($numRooms);
		$this->setNumBathrooms($numBathrooms);
		$this->setPrice($price);
		$this->setDescription($description);
		$this->setFeatures($features);
	}

	private static function withDatabaseRecord(array $row) {
		$temp = new self($row["name"], $row["supplier_id"], $row["address"], $row["district_id"], $row["property_type_id"], $row["num_guests"], $row["num_rooms"], $row["num_bathrooms"], $row["price"], $row["description"], $row);
		$temp->setID($row["id"]);
		return $temp;
	}

	public static function withID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("RentalProperty::withID expected integer ID, got " . gettype($id) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM rental_properties WHERE id = :id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();
			$result = $stmt->fetch();
			if ($result === false) {
				throw new OutOfBoundsException("Nonexistent property ID supplied to RentalProperty::withID.");
			}
			return self::withDatabaseRecord($result);
		} catch (PDOException $e) {
			throw new OutOfBoundsException("Invalid property ID supplied to RentalProperty::withID.");
		}
	}

	public static function getAllForSupplier($supplierID) {
		if (!Validate::int($supplierID)) {
			throw new InvalidArgumentException("RentalProperty::getAllForSupplier expected integer supplier ID, got " . gettype($supplierID) . " instead.");
		}
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->prepare("SELECT * FROM rental_properties WHERE supplier_id = :supplier_id");
			$stmt->bindParam(":supplier_id", $supplierID);
			$stmt->execute();
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$properties = [];
			foreach ($results as $row) {
				$properties[] = self::withDatabaseRecord($row);
			}
			return $properties;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the supplier's property list from the database.");
		}
	}

	public static function getAll() {
		try {
			$pdo  = DB::getHandle();
			$stmt = $pdo->query("SELECT * FROM rental_properties");
			$results = $stmt->fetchAll();
			if ($results === false) {
				return [];
			}
			$properties = [];
			foreach ($results as $row) {
				$properties[] = self::withDatabaseRecord($row);
			}
			return $properties;
		} catch (PDOException $e) {
			throw new ErrorException("Unable to retrieve the rental property list from the database.");
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

	public function getName() {
		return $this->name;
	}

	public function getSupplierID() {
		return $this->supplierID;
	}

	public function getSupplier() {
		return User::withID($this->supplierID);
	}

	public function getAddress() {
		return $this->address;
	}

	public function getDistrictID() {
		return $this->districtID;
	}
	
	public function getDistrictName() {
		return self::getCityDistricts()[$this->districtID];
	}

	public function getPropertyTypeID() {
		return $this->propertyTypeID;
	}

	public function getPropertyTypeName() {
		return self::getPropertyTypes()[$this->propertyTypeID];
	}

	public function getNumGuests() {
		return $this->numGuests;
	}

	public function getNumRooms() {
		return $this->numRooms;
	}

	public function getNumBathrooms() {
		return $this->numBathrooms;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getFeatures() {
		return [
			"has_air_conditioning"  => $this->hasAirConditioning  ? true : false,
			"has_cable_tv"          => $this->hasCableTV          ? true : false,
			"has_laundry_machines"  => $this->hasLaundryMachines  ? true : false,
			"has_parking"           => $this->hasParking          ? true : false,
			"has_gym"               => $this->hasGym              ? true : false,
			"has_internet"          => $this->hasInternet         ? true : false,
			"pets_allowed"          => $this->petsAllowed         ? true : false,
			"has_wheelchair_access" => $this->hasWheelchairAccess ? true : false,
			"has_pool"              => $this->hasPool             ? true : false,
			"has_transport_access"  => $this->hasTransportAccess  ? true : false,
			"has_private_bathroom"  => $this->hasPrivateBathroom  ? true : false,
		];
	}

	// setters

	private function setID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->id = $id;
	}

	public function setName($name) {
		if (!Validate::plainText($name)) {
			throw new InvalidArgumentException("Invalid property name supplied to setName.");
		}
		$this->name = $name;
	}

	public function setSupplierID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setSupplierID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->supplierID = $id;
	}

	public function setAddress($address) {
		if (!Validate::plainText($address)) {
			throw new InvalidArgumentException("Invalid text supplied to setAddress.");
		}
		$this->address = $address;
	}

	public function setDistrictID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setDistrictID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->districtID = $id;
	}

	public function setPropertyTypeID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setPropertyTypeID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->propertyTypeID = $id;
	}

	public function setNumGuests($numGuests) {
		if (!Validate::int($numGuests)) {
			throw new InvalidArgumentException("setNumGuests expected integer value, got " . gettype($numGuests) . " instead.");
		}
		$numGuests = (int) $numGuests;
		if ($numGuests < 1) {
			throw new InvalidArgumentException("Properties must allow at least one guest.");
		}
		$this->numGuests = $numGuests;
	}

	public function setNumRooms($numRooms) {
		if (!Validate::int($numRooms)) {
			throw new InvalidArgumentException("setNumRooms expected integer value, got " . gettype($numRooms) . " instead.");
		}
		$numRooms = (int) $numRooms;
		if ($numRooms < 1) {
			throw new InvalidArgumentException("Properties must have at least one room.");
		}
		$this->numRooms = $numRooms;
	}

	public function setNumBathrooms($numBathrooms) {
		if (!Validate::int($numBathrooms)) {
			throw new InvalidArgumentException("setNumBathrooms expected integer value, got " . gettype($numBathrooms) . " instead.");
		}
		$numBathrooms = (int) $numBathrooms;
		if ($numBathrooms < 0) {
			throw new InvalidArgumentException("Properties cannot have negative bathrooms!");
		}
		$this->numBathrooms = $numBathrooms;
	}

	public function setPrice($price) {
		if (!Validate::int($price)) {
			throw new InvalidArgumentException("setPrice expected integer for price, got " . gettype($price) . " instead.");
		}
		$price = (int) $price;
		if ($price < 0) {
			throw new InvalidArgumentException("The property price cannot be less than zero!");
		}
		$this->price = $price;
	}

	public function setDescription($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setDescription.");
		}
		$this->description = $text;
	}

	public function setFeatures(array $features) {
		$this->hasAirConditioning  = $features["has_air_conditioning"]  ? 1 : 0;
		$this->hasCableTV          = $features["has_cable_tv"]          ? 1 : 0;
		$this->hasLaundryMachines  = $features["has_laundry_machines"]  ? 1 : 0;
		$this->hasParking          = $features["has_parking"]           ? 1 : 0;
		$this->hasGym              = $features["has_gym"]               ? 1 : 0;
		$this->hasInternet         = $features["has_internet"]          ? 1 : 0;
		$this->petsAllowed         = $features["pets_allowed"]          ? 1 : 0;
		$this->hasWheelchairAccess = $features["has_wheelchair_access"] ? 1 : 0;
		$this->hasPool             = $features["has_pool"]              ? 1 : 0;
		$this->hasTransportAccess  = $features["has_transport_access"]  ? 1 : 0;
		$this->hasPrivateBathroom  = $features["has_private_bathroom"]  ? 1 : 0;
	}

}