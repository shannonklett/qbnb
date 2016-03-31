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

$features = $property->getFeatures();

include "pages/header.php";

$bannerText = "Property Details";

include "pages/banner.php";

?>

<div class="huge-padding"></div>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <img class="info-property-pic" width="100%" src="qbnb_website/images/property_1.jpg">
            <div class="info-property-price">$
                <?php echo $property->getPrice(); ?>.00</div>
        </div>
    </div>

<?php if (User::current()->isAdmin() || $property->getSupplierID() == User::current()->getID()) { ?>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<a class="pencil-icon" href="./?property=<?php echo $property->getID(); ?>&edit"><i class="fa fa-pencil"></i></a>
			<a class="remove-icon" href="./?property=<?php echo $property->getID(); ?>&delete"><i class="fa fa-times"></i></a>
		</div>
	</div>
<?php } else { ?>
	<div style="height: 1em"></div>
<?php } ?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="info-property-title form-group">
                <?php echo $property->getName(); ?></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="info-property-subtitle form-group">
                <?php echo $property->getAddress(); ?></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p class="property-description form-group">
                <?php echo $property->getDescription(); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="info-property-type">
                <table class="table table-striped">
                    <thead>

                        <tr>
                            <th><span class="prop-info-color">Property Information</span>
                            </th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Property District</strong>
                            </td>
                            <td>
                                <?php echo $property->getDistrict()->getName(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Property Type</strong>
                            </td>
                            <td>
                                <?php echo $property->getPropertyTypeName(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Max Guests</strong>
                            </td>
                            <td>
                                <?php echo $property->getNumGuests(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Number of Rooms</strong>
                            </td>
                            <td>
                                <?php echo $property->getNumRooms(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Number of Bathrooms</strong>
                            </td>
                            <td>
                                <?php echo $property->getNumBathrooms(); ?></td>
                        </tr>
                        <tr>
                            <td><strong>I have air conditioning</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_air_conditioning"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have cable tv</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_cable_tv"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have laundry machines</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_laundry_machines"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have parking</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_parking"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have a gym</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_gym"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have internet</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_internet"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I allow pets</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "pets_allowed"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have wheelchair access</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_wheelchair_access"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have a pool</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_pool"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have access to transport</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_transport_access"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>I have a private bathroom</strong>
                            </td>
                            <td>
                                <?php echo ($features[ "has_private_bathroom"]) ? 'Yes' : 'No'; ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="info-property-type">
                <table class="table table-striped">
                    <thead>

                        <tr>
                            <th><span class="prop-info-color">Property Bookings</span>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody>

                        <tr>
                            <td><strong>Booking #</strong>
                            </td>
                            <td><strong>Arrival Date</strong>
                            </td>
                            <td><strong>Departure Date</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>2017-06-02</td>
                            <td>2017-06-04</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 no-spacer-form-right col-md-offset-3">
            <input type="date" class="form-control" placeholder="A" required>
        </div>
        <div class="col-md-2 no-spacer-form">
            <input type="date" class="form-control" placeholder="D" required>
        </div>
        <div class="col-md-2 no-spacer-form-left">
            <button class="btn btn-default book-button btn-search" type="button">BOOK</button>
        </div>
    </div>

</div>

<div class="huge-padding"></div>

<?php include "pages/footer.php";