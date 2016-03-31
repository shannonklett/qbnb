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