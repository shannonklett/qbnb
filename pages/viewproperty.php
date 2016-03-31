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

include "pages/header.php";

$bannerText = "Property Details";
include "pages/banner.php";

?>

<div class="container">

	<div class="row">
		<div class="col-md-4 col-md-offset-4 info-property-pic-div"><img class="info-property-pic" src="qbnb_website/images/property_1.jpg"></div>
		<div class="col-md-4"><div class="info-property-price">$<?php echo $property->getPrice(); ?>.00</div></div>
	</div>

	<?php if (User::current()->isAdmin() ||  $property->getSupplierID() === User::current()->getID()) { ?>
		<a class="pencil-prop-icon" style="position: static" href="./?property=<?php echo $property->getID(); ?>&edit"><i class="fa fa-pencil"></i></a>
		<a class="remove-prop-icon" style="position: static" href="./?property=<?php echo $property->getID(); ?>&delete"><i class="fa fa-times"></i></a>

	<?php } ?>

	<div class="row">

		<div class="center-text">
			<div class="info-property-title"><?php echo $property->getName(); ?></div>
			<div class="info-property-subtitle"><?php echo $property->getAddress(); ?></div>
			<div class="info-property-type">Room type: <span><?php echo $property->getPropertyTypeName(); ?></span></div>

			<p class="property-description">Description:<br><?php echo $property->getDescription(); ?></p>

		</div>

	</div>

</div>

<?php

include "pages/footer.php";