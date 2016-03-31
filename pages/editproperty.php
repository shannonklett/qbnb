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

if (isset($_POST["propertyEditSubmit"])) {

	if (Validate::plainText($_POST["propertyname"]) && Validate::plainText($_POST["propertyaddress"]) && Validate::int($_POST["numberofguest"]) && Validate::int($_POST["numberofroom"]) && Validate::int($_POST["numberofbathroom"]) && Validate::int($_POST["price"]) && Validate::plainText($_POST["description"])) {

		$features = $property->getFeatures();

		$features["has_air_conditioning"] = isset($_POST["airconditioning"]);
		$features["has_cable_tv"] = isset($_POST["cabletv"]);
		$features["has_laundry_machines"] = isset($_POST["laundrymachines"]);
		$features["has_parking"] = isset($_POST["parking"]);
		$features["has_gym"] = isset($_POST["gym"]);
		$features["has_internet"] = isset($_POST["internet"]);
		$features["pets_allowed"] = isset($_POST["pets"]);
		$features["has_wheelchair_access"] = isset($_POST["wheelchairaccess"]);
		$features["has_pool"] = isset($_POST["pool"]);
		$features["has_transport_access"] = isset($_POST["transportaccess"]);
		$features["has_private_bathroom"] = isset($_POST["privatebathroom"]);

		$property->setName($_POST["propertyname"]);
		$property->setAddress($_POST["propertyaddress"]);
		$property->setNumGuests($_POST["numberofguest"]);
		$property->setNumRooms($_POST["numberofroom"]);
		$property->setNumBathrooms($_POST["numberofbathroom"]);
		$property->setPrice($_POST["price"]);
		$property->setDescription($_POST["description"]);
		$property->setFeatures($features);
		$success = $property->update();
		if ($success) {
			Session::redirect("./?property=" . $property->getID());
		}
	}

}

include "pages/header.php";

$bannerText = "Edit Property";
include "pages/banner.php";

?>

<div class="container">

	<form action="" method="post">
		<label for="pname">Property Name</label>
		<input type="text" id="pname" name="propertyname" value="<?php echo $property->getName(); ?>" required>

		<label for="address">Property Address</label>
		<input type="text" id="address" name="propertyaddress" value="<?php echo $property->getAddress(); ?>" required>

		<label for="district">Property District</label>
		<select name="propertydistrict" id="district">
			<?php foreach (RentalProperty::getCityDistricts() as $districtID => $district) { ?>
				<option value="<?php echo $districtID; ?>" <?php if ($districtID == $property->getDistrictID()) echo 'selected'; ?>><?php echo $district->getName(); ?></option>
			<?php } ?>
		</select>

		<label for="propertytype">Property Type</label>
		<select name="type" id="propertytype">
			<?php foreach (RentalProperty::getPropertyTypes() as $typeID => $typeName) { ?>
				<option value="<?php echo $typeID; ?>" <?php if ($typeID == $property->getPropertyTypeID()) echo 'selected'; ?>><?php echo $typeName; ?></option>
			<?php } ?>
		</select>

		<label for="numguest">Number of Guests</label>
		<input type="number" id="numguest" name="numberofguest" value="<?php echo $property->getNumGuests(); ?>" required>

		<label for="numroom">Number of Room</label>
		<input type="number" id="numroom" name="numberofroom" value="<?php echo $property->getNumRooms(); ?>" required>

		<label for="numbathroom">Number of Bathrooms</label>
		<input type="number" id="numbathroom" name="numberofbathroom" value="<?php echo $property->getNumBathrooms(); ?>" required>

		<label for="propertyprice">Property Price</label>
		<input type="number" id="propertyprice" name="price" required value="<?php echo $property->getPrice(); ?>">

		<label for="propertydesc">Description</label>
		<textarea id="propertydesc" name="description" required cols="50" rows="10"><?php echo $property->getDescription(); ?></textarea>

		<?php $features = $property->getFeatures(); ?>

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