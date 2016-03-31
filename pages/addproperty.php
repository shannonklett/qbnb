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

if (isset($_POST["propertyEditSubmit"])) {

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
			Session::redirect("./?property=" . $property->getID());
		}

	}

}

include "pages/header.php";

$bannerText = "Add Property";
include "pages/banner.php";

?>

<div class="container">

	<form action="" method="post">
		<label for="pname">Property Name</label>
		<input type="text" id="pname" name="propertyname" value="<?php echo $data["propertyname"]; ?>" required>

		<label for="address">Property Address</label>
		<input type="text" id="address" name="propertyaddress" value="<?php echo $data["propertyaddress"]; ?>" required>

		<label for="district">Property District</label>
		<select name="propertydistrict" id="district">
			<?php foreach (RentalProperty::getCityDistricts() as $districtID => $district) { ?>
				<option value="<?php echo $districtID; ?>" <?php if ($districtID == $data["propertydistrict"]) echo 'selected'; ?>><?php echo $district->getName(); ?></option>
			<?php } ?>
		</select>

		<label for="propertytype">Property Type</label>
		<select name="type" id="propertytype">
			<?php foreach (RentalProperty::getPropertyTypes() as $typeID => $typeName) { ?>
				<option value="<?php echo $typeID; ?>" <?php if ($typeID == $data["type"]) echo 'selected'; ?>><?php echo $typeName; ?></option>
			<?php } ?>
		</select>

		<label for="numguest">Number of Guests</label>
		<input type="number" id="numguest" name="numberofguest" value="<?php echo $data["numberofguest"]; ?>" required>

		<label for="numroom">Number of Rooms</label>
		<input type="number" id="numroom" name="numberofroom" value="<?php echo $data["numberofroom"]; ?>" required>

		<label for="numbathroom">Number of Bathrooms</label>
		<input type="number" id="numbathroom" name="numberofbathroom" value="<?php echo $data["numberofbathroom"]; ?>" required>

		<label for="propertyprice">Property Price</label>
		<input type="number" id="propertyprice" name="price" required value="<?php echo $data["price"]; ?>">

		<label for="propertydesc">Description</label>
		<textarea id="propertydesc" name="description" required cols="50" rows="10"><?php echo $data["description"]; ?></textarea>

		<label for="featuresairconditioning">I have air conditioning</label>
		<input type="checkbox" id="featuresairconditioning" name="airconditioning" <?php if ($features["has_air_conditioning"]) echo 'checked'; ?>>
		<label for="featurescabletv">I have cable tv</label>
		<input type="checkbox" id="featurescabletv" name="cabletv" <?php if ($features["has_cable_tv"]) echo 'checked'; ?>>
		<label for="featureslaundrymachines">I have laundry machines</label>
		<input type="checkbox" id="featureslaundrymachines" name="laundrymachines" <?php if ($features["has_laundry_machines"]) echo 'checked'; ?>>
		<label for="featuresparking">I have parking</label>
		<input type="checkbox" id="featuresparking" name="parking" <?php if ($features["has_parking"]) echo 'checked'; ?>>
		<label for="featuresgym">I have a gym</label>
		<input type="checkbox" id="featuresgym" name=gym" <?php if ($features["has_gym"]) echo 'checked'; ?>>
		<label for="featuresinternet">I have Internet</label>
		<input type="checkbox" id="featuresinternet" name="internet" <?php if ($features["has_internet"]) echo 'checked'; ?>>
		<label for="featurespets">I allow pets</label>
		<input type="checkbox" id="featurespets" name="pets" <?php if ($features["pets_allowed"]) echo 'checked'; ?>>
		<label for="featureswheelchairaccess">I have wheelchair access</label>
		<input type="checkbox" id="featureswheelchairaccess" name="wheelchairaccess" <?php if ($features["has_wheelchair_access"]) echo 'checked'; ?>>
		<label for="featurespool">I have a pool</label>
		<input type="checkbox" id="featurespool" name="pool" <?php if ($features["has_pool"]) echo 'checked'; ?>>
		<label for="featurestransportaccess">I have access to transport</label>
		<input type="checkbox" id="featurestransportaccess" name="transportaccess" <?php if ($features["has_transport_access"]) echo 'checked'; ?>>
		<label for="featuresprivatebathroom">I have a private bathroom</label>
		<input type="checkbox" id="featuresprivatebathroom" name="privatebathroom" <?php if ($features["has_private_bathroom"]) echo 'checked'; ?>>

		<input type="hidden" name="propertyEditSubmit">
		<button type="submit" class="btn">Save Changes</button>
	</form>

</div>

<?php

include "pages/footer.php";