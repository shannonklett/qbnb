<?php

$data = [
	"propertyname"     => "",
	"propertyaddress"  => "",
	"propertydistrict" => "",
	"type"             => "",
	"numberofguest"    => "",
	"numberofroom"     => "",
	"numberofbathroom" => "",
	"price"            => "",
	"description"      => "",
];

$features = [
	"has_air_conditioning"  => false,
	"has_cable_tv"          => false,
	"has_laundry_machines"  => false,
	"has_parking"           => false,
	"has_gym"               => false,
	"has_internet"          => false,
	"pets_allowed"          => false,
	"has_wheelchair_access" => false,
	"has_pool"              => false,
	"has_transport_access"  => false,
	"has_private_bathroom"  => false,
];

if (isset($_POST["propertyAddSubmit"])) {

	$data["propertyname"] = $_POST["propertyname"];
	$data["propertyaddress"] = $_POST["propertyaddress"];
	$data["propertydistrict"] = $_POST["propertydistrict"];
	$data["type"] = $_POST["type"];
	$data["numberofguest"] = $_POST["numberofguest"];
	$data["numberofroom"] = $_POST["numberofroom"];
	$data["numberofbathroom"] = $_POST["numberofbathroom"];
	$data["price"] = $_POST["price"];
	$data["description"] = $_POST["description"];

	$features = [
		"has_air_conditioning"  => isset($_POST["airconditioning"]),
		"has_cable_tv"          => isset($_POST["cabletv"]),
		"has_laundry_machines"  => isset($_POST["laundrymachines"]),
		"has_parking"           => isset($_POST["parking"]),
		"has_gym"               => isset($_POST["gym"]),
		"has_internet"          => isset($_POST["internet"]),
		"pets_allowed"          => isset($_POST["pets"]),
		"has_wheelchair_access" => isset($_POST["wheelchairaccess"]),
		"has_pool"              => isset($_POST["pool"]),
		"has_transport_access"  => isset($_POST["transportaccess"]),
		"has_private_bathroom"  => isset($_POST["privatebathroom"]),
	];

	if (Validate::plainText($_POST["propertyname"]) && Validate::plainText($_POST["propertyaddress"]) && Validate::int($_POST["numberofguest"]) && Validate::int($_POST["numberofroom"]) && Validate::int($_POST["numberofbathroom"]) && Validate::int($_POST["price"]) && Validate::plainText($_POST["description"])) {

		$property = new RentalProperty($_POST["propertyname"], User::current()->getID(), $_POST["propertyaddress"], $_POST["propertydistrict"], $_POST["type"], $_POST["numberofguest"], $_POST["numberofroom"], $_POST["numberofbathroom"], $_POST["price"], $_POST["description"], $features);
		$success = $property->insert();
		if ($success) {
			if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
				try {
					$success = $property->setImage($_FILES["image"]);
				} catch (Exception $e) {}
			}
			Session::redirect("./?property=" . $property->getID());
		}

	}

}

include "pages/header.php";

$bannerText = "Add Property";
include "pages/banner.php";

?>

<div class="huge-padding"></div>

<div class="container">

	<form action="" method="post" enctype="multipart/form-data">

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<label for="pname">Property Name</label>
				<input class="form-control" type="text" id="pname" name="propertyname" value="<?php echo $data["propertyname"]; ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<label for="address">Property Address</label>
				<input class="form-control" type="text" id="address" name="propertyaddress" value="<?php echo $data["propertyaddress"]; ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 col-md-offset-3"><label for="district">Property District</label>
				<select class="form-control select-search-form" name="propertydistrict" id="district">
					<?php foreach (RentalProperty::getCityDistricts() as $districtID => $district) { ?>
						<option value="<?php echo $districtID; ?>" <?php if ($districtID == $data["propertydistrict"]) echo 'selected'; ?>><?php echo $district->getName(); ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-3"><label for="propertytype">Property Type</label>
				<select class="form-control select-search-form" name="type" id="propertytype">
					<?php foreach (RentalProperty::getPropertyTypes() as $typeID => $typeName) { ?>
						<option value="<?php echo $typeID; ?>" <?php if ($typeID == $data["type"]) echo 'selected'; ?>><?php echo $typeName; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-3"><label for="numguest">Max Guests</label>
				<input class="form-control" type="number" id="numguest" name="numberofguest" value="<?php echo $data["numberofguest"]; ?>" required>
			</div>
			<div class="col-md-2"><label for="numroom">Number of Rooms</label>
				<input class="form-control" type="number" id="numroom" name="numberofroom" value="<?php echo $data["numberofroom"]; ?>" required>
			</div>
			<div class="col-md-2"><label for="numbathroom">Number of Bathrooms</label>
				<input class="form-control" type="number" id="numbathroom" name="numberofbathroom" value="<?php echo $data["numberofbathroom"]; ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3"><label for="propertyprice">Property Price ($)</label>
				<input class="form-control" type="number" id="propertyprice" name="price" required value="<?php echo $data["price"]; ?>">
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3"><label for="propertydesc">Description</label>
				<textarea class="form-control" id="propertydesc" name="description" required rows="10"><?php echo $data["description"]; ?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-3"><label for="image">Preview Image</label>
				<input type="file" name="image" id="image" style="margin-bottom: 3em;">
			</div>
		</div>

		<div class="row">

			<div class="col-md-2 col-md-offset-3"><label for="featuresairconditioning">I have air conditioning</label>
				<input class="form-control bottom-mar" type="checkbox" id="featuresairconditioning" name="airconditioning" <?php if ($features["has_air_conditioning"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featurescabletv">I have cable tv</label>
				<input class="form-control bottom-mar" type="checkbox" id="featurescabletv" name="cabletv" <?php if ($features["has_cable_tv"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featureslaundrymachines">I have laundry machines</label>
				<input class="form-control bottom-mar" type="checkbox" id="featureslaundrymachines" name="laundrymachines" <?php if ($features["has_laundry_machines"]) echo 'checked'; ?>>
			</div>

		</div>

		<div class="row">

			<div class="col-md-2 col-md-offset-3"><label for="featuresparking">I have parking</label>
				<input class="form-control bottom-mar" type="checkbox" id="featuresparking" name="parking" <?php if ($features["has_parking"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featuresgym">I have a gym</label>
				<input class="form-control bottom-mar" type="checkbox" id="featuresgym" name="gym" <?php if ($features["has_gym"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featuresinternet">I have internet</label>
				<input class="form-control bottom-mar" type="checkbox" id="featuresinternet" name="internet" <?php if ($features["has_internet"]) echo 'checked'; ?>>
			</div>

		</div>

		<div class="row">

			<div class="col-md-2 col-md-offset-3"><label for="featurespets">I allow pets</label>
				<input class="form-control bottom-mar" type="checkbox" id="featurespets" name="pets" <?php if ($features["pets_allowed"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featureswheelchairaccess">I have wheelchair access</label>
				<input class="form-control bottom-mar" type="checkbox" id="featureswheelchairaccess" name="wheelchairaccess" <?php if ($features["has_wheelchair_access"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featurespool">I have a pool</label>
				<input class="form-control bottom-mar" type="checkbox" id="featurespool" name="pool" <?php if ($features["has_pool"]) echo 'checked'; ?>>
			</div>

		</div>

		<div class="row">

			<div class="col-md-2 col-md-offset-3"><label for="featurestransportaccess">I have access to transport</label>
				<input class="form-control bottom-mar" type="checkbox" id="featurestransportaccess" name="transportaccess" <?php if ($features["has_transport_access"]) echo 'checked'; ?>>
			</div>

			<div class="col-md-2"><label for="featuresprivatebathroom">I have a private bathroom</label>
				<input class="form-control bottom-mar" type="checkbox" id="featuresprivatebathroom" name="privatebathroom" <?php if ($features["has_private_bathroom"]) echo 'checked'; ?>>
			</div>

		</div>

		<input type="hidden" name="propertyAddSubmit">
		<div class="col-md-3 col-md-offset-5"><button class="btn register-btn" type="submit">Submit</button></div>
	</form>

	<div class="huge-padding"></div>

</div>

<?php

include "pages/footer.php";