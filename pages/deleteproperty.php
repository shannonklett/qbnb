<?php

if (!isset($_GET["property"]) || !Validate::int($_GET["property"])) {
	Session::redirect("./");
}

$property = (int) $_GET["property"];
try {
	$property = RentalProperty::withID($property);
} catch (Exception $e) {
	Session::redirect("./");
}

if (!User::current()->isAdmin() &&  $property->getSupplierID() !== User::current()->getID()) {
	Session::redirect("./?property=" . $property->getID());
}

$success = $property->delete();

if ($success) {
	Session::redirect("./?myproperties");
} else {
	Session::redirect("./?property=" . $property->getID());
}

if (isset($_POST["propertyEditSubmit"])) {

	if (Validate::plainText($_POST["propertyname"]) && Validate::plainText($_POST["propertyaddress"]) && Validate::int($_POST["numberofguest"]) && Validate::int($_POST["numberofroom"]) && Validate::int($_POST["numberofbathroom"]) && Validate::int($_POST["price"]) && Validate::plainText($_POST["description"])) {
		$property->setName($_POST["propertyname"]);
		$property->setAddress($_POST["propertyaddress"]);
		$property->setNumGuests($_POST["numberofguest"]);
		$property->setNumRooms($_POST["numberofroom"]);
		$property->setNumBathrooms($_POST["numberofbathroom"]);
		$property->setPrice($_POST["price"]);
		$property->setDescription($_POST["description"]);
		$success = $property->update();
		if ($success) {
			Session::redirect("./?property=" . $property->getID());
		}
	}

}