<?php

class RentalProperty {

	private static $propertyTypes;
	private static $cityDistricts;

	/**
	 * @return string[]
	 */
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

	/**
	 * @return CityDistrict[]
	 */
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

	/**
	 * @param int $id
	 *
	 * @return RentalProperty
	 */
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

	/**
	 * @param int $supplierID
	 *
	 * @return RentalProperty[]
	 * @throws ErrorException
	 */
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

	/**
	 * @return RentalProperty[]
	 * @throws ErrorException
	 */
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

	/**
	 * @return bool
	 */
	public function insert() {
		if ($this->id) {
			throw new BadMethodCallException("Attempt to insert existing record.");
		}
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("INSERT INTO rental_properties (id, name, supplier_id, address, district_id, property_type_id, num_guests, num_rooms, num_bathrooms, price, description, has_air_conditioning, has_cable_tv, has_laundry_machines, has_parking, has_gym, has_internet, pets_allowed, has_wheelchair_access, has_pool, has_transport_access, has_private_bathroom) VALUES (NULL, :name, :supplier_id, :address, :district_id, :property_type_id, :num_guests, :num_rooms, :num_bathrooms, :price, :description, :has_air_conditioning, :has_cable_tv, :has_laundry_machines, :has_parking, :has_gym, :has_internet, :pets_allowed, :has_wheelchair_access, :has_pool, :has_transport_access, :has_private_bathroom)");
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":supplier_id", $this->supplierID);
			$stmt->bindParam(":address", $this->address);
			$stmt->bindParam(":district_id", $this->districtID);
			$stmt->bindParam(":property_type_id", $this->propertyTypeID);
			$stmt->bindParam(":num_guests", $this->numGuests);
			$stmt->bindParam(":num_rooms", $this->numRooms);
			$stmt->bindParam(":num_bathrooms", $this->numBathrooms);
			$stmt->bindParam(":price", $this->price);
			$stmt->bindParam(":description", $this->description);
			$stmt->bindParam(":has_air_conditioning", $this->hasAirConditioning);
			$stmt->bindParam(":has_cable_tv", $this->hasCableTV);
			$stmt->bindParam(":has_laundry_machines", $this->hasLaundryMachines);
			$stmt->bindParam(":has_parking", $this->hasParking);
			$stmt->bindParam(":has_gym", $this->hasGym);
			$stmt->bindParam(":has_internet", $this->hasInternet);
			$stmt->bindParam(":pets_allowed", $this->petsAllowed);
			$stmt->bindParam(":has_wheelchair_access", $this->hasWheelchairAccess);
			$stmt->bindParam(":has_pool", $this->hasPool);
			$stmt->bindParam(":has_transport_access", $this->hasTransportAccess);
			$stmt->bindParam(":has_private_bathroom", $this->hasPrivateBathroom);
			$stmt->execute();
			$this->id = $pdo->lastInsertId();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function update() {
		if (!$this->id) {
			throw new BadMethodCallException("Attempt to update nonexistent record.");
		}
		try {
			$pdo = DB::getHandle();
			$stmt = $pdo->prepare("UPDATE rental_properties SET name = :name, supplier_id = :supplier_id, address = :address, district_id = :district_id, property_type_id = :property_type_id, num_guests = :num_guests, num_bathrooms = :num_bathrooms, price = :price, description = :description, has_air_conditioning = :has_air_conditioning, has_cable_tv = :has_cable_tv, has_laundry_machines = :has_laundry_machines, has_parking = :has_parking, has_gym = :has_gym, has_internet = :has_internet, pets_allowed = :pets_allowed, has_wheelchair_access = :has_wheelchair_access, has_pool = :has_pool, has_transport_access = :has_transport_access, has_private_bathroom = :has_private_bathroom WHERE id = :id");
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":supplier_id", $this->supplierID);
			$stmt->bindParam(":address", $this->address);
			$stmt->bindParam(":district_id", $this->districtID);
			$stmt->bindParam(":property_type_id", $this->propertyTypeID);
			$stmt->bindParam(":num_guests", $this->numGuests);
			$stmt->bindParam(":num_rooms", $this->numRooms);
			$stmt->bindParam(":num_bathrooms", $this->numBathrooms);
			$stmt->bindParam(":price", $this->price);
			$stmt->bindParam(":description", $this->description);
			$stmt->bindParam(":has_air_conditioning", $this->hasAirConditioning);
			$stmt->bindParam(":has_cable_tv", $this->hasCableTV);
			$stmt->bindParam(":has_laundry_machines", $this->hasLaundryMachines);
			$stmt->bindParam(":has_parking", $this->hasParking);
			$stmt->bindParam(":has_gym", $this->hasGym);
			$stmt->bindParam(":has_internet", $this->hasInternet);
			$stmt->bindParam(":pets_allowed", $this->petsAllowed);
			$stmt->bindParam(":has_wheelchair_access", $this->hasWheelchairAccess);
			$stmt->bindParam(":has_pool", $this->hasPool);
			$stmt->bindParam(":has_transport_access", $this->hasTransportAccess);
			$stmt->bindParam(":has_private_bathroom", $this->hasPrivateBathroom);
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
			$stmt = $pdo->prepare("DELETE FROM rental_properties WHERE id = :id");
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
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getSupplierID() {
		return $this->supplierID;
	}

	/**
	 * @return User
	 */
	public function getSupplier() {
		return User::withID($this->supplierID);
	}

	/**
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @return int
	 */
	public function getDistrictID() {
		return $this->districtID;
	}

	/**
	 * @return CityDistrict
	 */
	public function getDistrict() {
		return self::getCityDistricts()[$this->districtID];
	}

	/**
	 * @return int
	 */
	public function getPropertyTypeID() {
		return $this->propertyTypeID;
	}

	/**
	 * @return string
	 */
	public function getPropertyTypeName() {
		return self::getPropertyTypes()[$this->propertyTypeID];
	}

	/**
	 * @return int
	 */
	public function getNumGuests() {
		return $this->numGuests;
	}

	/**
	 * @return int
	 */
	public function getNumRooms() {
		return $this->numRooms;
	}

	/**
	 * @return int
	 */
	public function getNumBathrooms() {
		return $this->numBathrooms;
	}

	/**
	 * @return int
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return bool[]
	 */
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
	 * @param string $name
	 */
	public function setName($name) {
		if (!Validate::plainText($name)) {
			throw new InvalidArgumentException("Invalid property name supplied to setName.");
		}
		$this->name = $name;
	}

	/**
	 * @param int $id
	 */
	public function setSupplierID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setSupplierID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->supplierID = $id;
	}

	/**
	 * @param string $address
	 */
	public function setAddress($address) {
		if (!Validate::plainText($address)) {
			throw new InvalidArgumentException("Invalid text supplied to setAddress.");
		}
		$this->address = $address;
	}

	/**
	 * @param int $id
	 */
	public function setDistrictID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setDistrictID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->districtID = $id;
	}

	/**
	 * @param int $id
	 */
	public function setPropertyTypeID($id) {
		if (!Validate::int($id)) {
			throw new InvalidArgumentException("setPropertyTypeID expected integer ID, got " . gettype($id) . " instead.");
		}
		$id = (int) $id;
		$this->propertyTypeID = $id;
	}

	/**
	 * @param int $numGuests
	 */
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

	/**
	 * @param int $numRooms
	 */
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

	/**
	 * @param int $numBathrooms
	 */
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

	/**
	 * @param int $price
	 */
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

	/**
	 * @param string $text
	 */
	public function setDescription($text) {
		if (!Validate::plainText($text, true)) {
			throw new InvalidArgumentException("Invalid text supplied to setDescription.");
		}
		$this->description = $text;
	}

	/**
	 * @param bool[] $features
	 */
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