<?php

if (!isset($_GET["deleteuser"])) {
	Session::redirect("./");
}

if ($_GET["deleteuser"] == "") {
	$user = User::current();
} else if (Validate::int($_GET["deleteuser"])) {
	$user = (int) $_GET["deleteuser"];
	try {
		$user = User::withID($user);
	} catch (Exception $e) {
		Session::redirect("./");
	}
} else {
	Session::redirect("./");
}

if (!User::current()->isAdmin() && $_GET["deleteuser"] != User::current()->getID()) {
	Session::redirect("./");
}

$success = $user->delete();

Session::redirect("./?admin");