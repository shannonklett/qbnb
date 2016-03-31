<?php

if (!isset($_GET["rejectbooking"]) || !Validate::int($_GET["rejectbooking"])) {
	Session::redirect("./");
}

$booking = (int) $_GET["rejectbooking"];
try {
	$booking = Booking::withID($booking);
} catch (Exception $e) {
	Session::redirect("./");
}

if ($booking->getRentalProperty()->getSupplierID() !== User::current()->getID()) {
	Session::redirect("./");
}

$booking->setStatusID(3);
$success = $booking->update();

Session::redirect("./");