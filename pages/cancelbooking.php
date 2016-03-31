<?php

if (!isset($_GET["cancelbooking"]) || !Validate::int($_GET["cancelbooking"])) {
	Session::redirect("./");
}

$booking = (int) $_GET["cancelbooking"];
try {
	$booking = Booking::withID($booking);
} catch (Exception $e) {
	Session::redirect("./");
}

if (!User::current()->isAdmin() && $booking->getConsumerID() !== User::current()->getID()) {
	Session::redirect("./");
}

$success = $booking->delete();

Session::redirect("./");