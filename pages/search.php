<?php

$results = false;

$features = [
	"has_air_conditioning"  => "Has air conditioning",
	"has_cable_tv"          => "Has cable TV",
	"has_laundry_machines"  => "Has laundry machines",
	"has_parking"           => "Has parking",
	"has_gym"               => "Has gym",
	"has_internet"          => "Has Internet",
	"pets_allowed"          => "Pets allowed",
	"has_wheelchair_access" => "Has wheelchair access",
	"has_pool"              => "Has pool",
	"has_transport_access"  => "Has transport access",
	"has_private_bathroom"  => "Has private bathroom",
];

if (isset($_POST["searchSubmit"])) {

	if ($_POST["features"] == "0") {
		$feature = "";
	} else {
		$feature = $_POST["features"];
	}

	if ($_POST["maxprice"]) {
		$maxPrice = (int) $_POST["maxprice"];
		if ($maxPrice <= 0) {
			$maxPrice = 0;
		}
	} else {
		$maxPrice = false;
	}

	$results = RentalProperty::search($_POST["district"], $_POST["type"], $feature, $maxPrice);

}

include "pages/header.php"; ?>

	<div id="banner" class="search-header image-bg">
		<div class="overlay-bg"></div>
		<div class="container">
			<form class="row search-bar" action="" method="post">
				<input type="hidden" name="searchSubmit">

				<div class="col-md-3" style="padding-left: 0; padding-right: 0">
					<select class="form-control select-search-form" name="district">
						<option value="0">Select District</option>
						<option disabled>──────────</option>
						<?php foreach (RentalProperty::getCityDistricts() as $districtID => $district) { ?>
						<option value="<?php echo $districtID; ?>"><?php echo $district->getName(); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3" style="padding-left: 0; padding-right: 0">
					<select class="form-control select-search-form" name="type">
						<option value="0">Select Type</option>
						<option disabled>──────────</option>
						<?php foreach (RentalProperty::getPropertyTypes() as $typeID => $typeName) { ?>
						<option value="<?php echo $typeID; ?>"><?php echo $typeName; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3" style="padding-left: 0; padding-right: 0">
					<select class="form-control select-search-form" name="features">
						<option value="0">Select Feature</option>
						<option disabled>──────────</option>
						<?php foreach ($features as $featureName => $featureText) { ?>
							<option value="<?php echo $featureName; ?>"><?php echo $featureText; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2" style="padding-left: 0; padding-right: 0"><input type="number" min="0" class="form-control" name="maxprice" placeholder="Max Price"></div>
				<div class="col-md-1" style="padding-left: 0; padding-right: 0"><button class="btn btn-default btn-search" type="submit">SEARCH</button></div>

			</form>
		</div>
	</div>

<?php if ($results) {

	$grid = [];

	foreach ($results as $property) {
		$text =
			'<div class="col-sm-6">
				<a class="property-block" href="./?property=' . $property->getID() . '" style="display: block; color: inherit">
					<img class="property-pic" src="qbnb_website/images/property_1.jpg">
					<span class="property-info" style="display: block">
						<span class="property-title">' . $property->getName() . '</span>
						<span class="property-address">' . $property->getAddress() . '</span>
						<span class="property-type">' . $property->getPropertyTypeName() . '</span>
						<span class="price-tag" style="display: block"></span>
						<span id="price-text">$' . $property->getPrice() . '.00</span>';
		if (User::current()->isAdmin() || $property->getSupplierID() == User::current()->getID()) {
		$text .=
						'<a class="pencil-prop-icon" href="./?property=' . $property->getID() . '&edit"><i class="fa fa-pencil"></i></a>
	                    <a class="remove-prop-icon" href="./?property=' . $property->getID() . '&delete"><i class="fa fa-times"></i></a>';
		}
		$text .=
					'</span>
				</a>
			</div>
			';
		$grid[] = $text;
	}


	if (count($grid) % 2 == 1) {
		$grid[] = '';
	}

	?>

	<div class="container">
		<?php

		for ($i = 0; $i < count($grid); $i++) {
			$odd = ($i % 2 == 1);
			if (!$odd) {
				echo '<div class="row">' . PHP_EOL;
			}
			echo $grid[$i];
			if ($odd) {
				echo '</div>' . PHP_EOL;
			}
		}

		?>
	</div>

<?php

}

include "pages/footer.php";