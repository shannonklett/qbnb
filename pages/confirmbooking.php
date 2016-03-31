<?php

if (!isset($_GET["confirmbooking"]) || !Validate::int($_GET["confirmbooking"])) {
	Session::redirect("./");
}

$booking = (int) $_GET["confirmbooking"];
try {
	$booking = Booking::withID($booking);
} catch (Exception $e) {
	Session::redirect("./");
}

if ($booking->getRentalProperty()->getSupplierID() !== User::current()->getID()) {
	Session::redirect("./");
}

$booking->setStatusID(2);
$success = $booking->update();

Session::redirect("./");