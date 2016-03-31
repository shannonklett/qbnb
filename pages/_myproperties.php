<?php

$propertyGrid = [
	'<div class="col-sm-6">
		<a class="empty-property" href="./?addproperty" style="display: block">
			<i class="fa fa-plus add-icon"></i>
			<span class="add-property">Add Property</span>
		</a>
	</div>
	'
];

foreach (RentalProperty::getAllForSupplier(User::current()->getID()) as $property) {
	$propertyGrid[] =
		'<div class="col-sm-6">
			<a class="property-block" href="./?property=' . $property->getID() . '" style="display: block; color: inherit">
				<img class="property-pic" src="qbnb_website/images/property_1.jpg">
				<span class="property-info" style="display: block">
					<span class="property-title">' . $property->getName() . '</span>
					<span class="property-address">' . $property->getAddress() . '</span>
					<span class="property-type">' . $property->getPropertyTypeName() . '</span>
					<span class="price-tag" style="display: block"></span>
					<span id="price-text">$' . $property->getPrice() . '.00</span>
					<a class="pencil-prop-icon" href="./?property=' . $property->getID() . '&edit"><i class="fa fa-pencil"></i></a>
                    <a class="remove-prop-icon" href="./?property=' . $property->getID() . '&delete"><i class="fa fa-times"></i></a>
				</span>
			</a>
		</div>
		';
}


if (count($propertyGrid) % 2 == 1) {
	$propertyGrid[] = '';
}

?>

<div class="container">
	<?php

	for ($i = 0; $i < count($propertyGrid); $i++) {
		$odd = ($i % 2 == 1);
		if (!$odd) {
			echo '<div class="row">' . PHP_EOL;
		}
		echo $propertyGrid[$i];
		if ($odd) {
			echo '</div>' . PHP_EOL;
		}
	}

	?>
</div>