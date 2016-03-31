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

$features = $property->getFeatures();

if (isset($_POST["propertyEditSubmit"])) {

	if (Validate::plainText($_POST["propertyname"]) && Validate::plainText($_POST["propertyaddress"]) && Validate::int($_POST["numberofguest"]) && Validate::int($_POST["numberofroom"]) && Validate::int($_POST["numberofbathroom"]) && Validate::int($_POST["price"]) && Validate::plainText($_POST["description"])) {

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
		$property->setDistrictID($_POST["propertydistrict"]);
		$property->setPropertyTypeID($_POST["type"]);
		$property->setNumGuests($_POST["numberofguest"]);
		$property->setNumRooms($_POST["numberofroom"]);
		$property->setNumBathrooms($_POST["numberofbathroom"]);
		$property->setPrice($_POST["price"]);
		$property->setDescription($_POST["description"]);
		$property->setFeatures($features);
		$success = $property->update();
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

$bannerText = "Edit Property";
include "pages/banner.php";

?>

<div class="huge-padding"></div>

    <div class="container">

        <form action="" method="post" enctype="multipart/form-data">

        <div class="row">
          <div class="col-md-6 col-md-offset-3">
	          <label for="pname">Property Name</label>
	          <input class="form-control" type="text" id="pname" name="propertyname" value="<?php echo $property->getName(); ?>" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-md-offset-3">
	          <label for="address">Property Address</label>
	          <input class="form-control" type="text" id="address" name="propertyaddress" value="<?php echo $property->getAddress(); ?>" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 col-md-offset-3"><label for="district">Property District</label>
            <select class="form-control select-search-form" name="propertydistrict" id="district">
			<?php foreach (RentalProperty::getCityDistricts() as $districtID => $district) { ?>
				<option value="<?php echo $districtID; ?>" <?php if ($districtID == $property->getDistrictID()) echo 'selected'; ?>><?php echo $district->getName(); ?></option>
			<?php } ?>
			</select>
          </div>
          <div class="col-md-3"><label for="propertytype">Property Type</label>
            <select class="form-control select-search-form" name="type" id="propertytype">
			<?php foreach (RentalProperty::getPropertyTypes() as $typeID => $typeName) { ?>
				<option value="<?php echo $typeID; ?>" <?php if ($typeID == $property->getPropertyTypeID()) echo 'selected'; ?>><?php echo $typeName; ?></option>
			<?php } ?>
			</select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-2 col-md-offset-3"><label for="numguest">Max Guests</label>
            <input class="form-control" type="number" min="1" id="numguest" name="numberofguest" value="<?php echo $property->getNumGuests(); ?>" required>
          </div>
          <div class="col-md-2"><label for="numroom">Number of Rooms</label>
            <input class="form-control" type="number" min="1" id="numroom" name="numberofroom" value="<?php echo $property->getNumRooms(); ?>" required>
          </div>
          <div class="col-md-2"><label for="numbathroom">Number of Bathrooms</label>
            <input class="form-control" type="number" min="0" id="numbathroom" name="numberofbathroom" value="<?php echo $property->getNumBathrooms(); ?>" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-md-offset-3"><label for="propertyprice">Property Price ($)</label>
            <input class="form-control" type="number" min="0" id="propertyprice" name="price" required value="<?php echo $property->getPrice(); ?>">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-md-offset-3"><label for="propertydesc">Description</label>
            <textarea class="form-control" id="propertydesc" name="description" required rows="10"><?php echo $property->getDescription(); ?></textarea>
          </div>
        </div>

        <div class="row">
	        <div class="col-md-6 col-md-offset-3"><label for="image">Replace Preview Image</label>
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

        <div class="row">
        
        	<input type="hidden" name="propertyEditSubmit">
        	<div class="col-md-3 col-md-offset-5"><button class="btn register-btn" type="submit">Save Changes</button></div>

        </div>

        </form>

        <div class="huge-padding"></div>

    </div>

<?php

include "pages/footer.php";