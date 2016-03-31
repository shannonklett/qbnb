<?php

// TODO remove this in production
ini_set("display_errors", "1");

// register the classes directory for auto-loading
spl_autoload_register(function($class) {
	include_once "classes/$class.php";
});

if (isset($_GET["logout"])) {
	Session::logout();
}

if (isset($_GET["register"])) {
	include "pages/register.php";
	die();
}

if (!Session::authenticate()) {
	include "pages/login.php";
	die();
}

// we are in! user exists

if (isset($_GET["search"])) {
	include "pages/search.php";
	die();
}

if (isset($_GET["addproperty"])) {
	include "pages/addproperty.php";
	die();
}

if (isset($_GET["property"])) {

	if (isset($_GET["edit"])) {
		include "pages/editproperty.php";
		die();
	}

	if (isset($_GET["delete"])) {
		include "pages/deleteproperty.php";
		die();
	}

	include "pages/viewproperty.php";
	die();
}

if (isset($_GET["myproperties"])) {
	include "pages/myproperties.php";
	die();
}

if (isset($_GET["settings"])) {
	include "pages/settings.php";
	die();
}

if (isset($_GET["admin"])) {
	include "pages/admin.php";
	die();
}

include "pages/index.php";
die();
