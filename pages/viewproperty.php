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

if (isset($_POST["bookingAddSubmit"])) {

	$booking = new Booking(User::current()->getID(), $property->getID(), DateTime::createFromFormat(Format::MYSQL_DATE_FORMAT, $_POST["startdate"]), DateTime::createFromFormat(Format::MYSQL_DATE_FORMAT, $_POST["enddate"]), 1);
	$success = $booking->insert();

}

if (isset($_POST["reviewAddSubmit"])) {

	$exists = true;
	try {
		Review::getSingle(User::current()->getID(), $property->getID());
	} catch (Exception $e) {
		$exists = false;
	}

	if (!$exists) {
		$review = new Review(User::current()->getID(), $property->getID(), $_POST["optradio"], $_POST["review"], "");
		$review->insert();
	}

}

if (isset($_POST["reviewReplySubmit"])) {

	if (User::current()->getID() !== $property->getSupplierID()) {
		Session::redirect("./?property=" . $property->getID());
	}

	if (!Validate::int($_GET["reviewreply"])) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review = (int) $_GET["reviewreply"];
	try {
		$review = Review::getSingle($review, $property->getID());
	} catch (Exception $e) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review->setReply($_POST["reply"]);
	$review->update();
	Session::redirect("./?property=" . $property->getID());

}

if (isset($_GET["deletereview"])) {
	if (!Validate::int($_GET["deletereview"])) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review = (int) $_GET["deletereview"];
	try {
		$review = Review::getSingle($review, $property->getID());
	} catch (Exception $e) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review->delete();
	Session::redirect("./?property=" . $property->getID());
}

if (isset($_GET["deletereply"])) {
	if (!Validate::int($_GET["deletereply"])) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review = (int) $_GET["deletereply"];
	try {
		$review = Review::getSingle($review, $property->getID());
	} catch (Exception $e) {
		Session::redirect("./?property=" . $property->getID());
	}
	$review->setReply("");
	$review->update();
	Session::redirect("./?property=" . $property->getID());
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
	        <?php if ($property->getImage()) { ?>
		        <img class="info-property-pic" width="100%" src="<?php echo $property->getImage(); ?>">
	        <?php } else { ?>
		        <img class="info-property-pic" width="100%" src="qbnb_website/images/property_1.jpg">
	        <?php } ?>

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
                Listed by <?php echo $property->getSupplier()->getFullName(); ?><br><?php echo $property->getAddress(); ?></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p class="property-description form-group">
                <?php echo nl2br($property->getDescription()); ?></p>
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
							<th><span class="prop-info-color">Current Bookings</span></th>
							<th></th>
						</tr>

						</thead>
						<tbody>

						<tr>
							<td><strong>Arrival Date</strong></td>
							<td><strong>Departure Date</strong></td>
						</tr>

						<?php foreach (Booking::getAllForProperty($property->getID()) as $booking) { ?>
							<tr>
								<td><?php echo $booking->getStartDate()->format(Format::DATE_FORMAT); ?></td>
								<td><?php echo $booking->getEndDate()->format(Format::DATE_FORMAT); ?></td>
							</tr>
						<?php } ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>

	<?php if (User::current()->getID() !== $property->getSupplierID()) { ?>

		<div class="row">
			<form action="" method="post">
				<div class="col-md-2 no-spacer-form-right col-md-offset-3">
					<?php
					$now = new DateTime();
					$now = $now->format(Format::MYSQL_DATE_FORMAT);
					?>
					<input type="date" value="<?php echo $now; ?>" name="startdate" class="form-control" placeholder="A" required>
				</div>
				<div class="col-md-2 no-spacer-form">
					<input type="date" value="<?php echo $now; ?>" name="enddate" class="form-control" placeholder="D" required>
				</div>
				<div class="col-md-2 no-spacer-form-left">
					<input type="hidden" name="bookingAddSubmit">
					<button class="btn btn-default book-button btn-search" type="submit">BOOK</button>
				</div>
			</form>
		</div>

	<?php } ?>

	<div class="small-padding"></div>

	<?php foreach (Review::getAllForProperty($property->getID()) as $review) { ?>

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-primary">
					<div class=panel-heading>
						<h3 class="panel-title">(<?php echo $review->getRating() ?>/5) Review by <strong><?php echo $review->getConsumer()->getFirstName(); ?></strong></h3>
						<?php if (User::current()->getID() == $property->getSupplierID()) { ?>
							<a class="font-white panel-icon-2" href="./?property=<?php echo $property->getID(); ?>&reviewreply=<?php echo $review->getConsumerID(); ?>"><i class="fa fa-reply"></i></a>
						<?php }
						if (User::current()->isAdmin() || User::current()->getID() == $property->getSupplierID() || User::current()->getID() == $review->getConsumerID()) { ?>
							<a class="font-red panel-icon-1" href="./?property=<?php echo $property->getID(); ?>&deletereview=<?php echo $review->getConsumerID(); ?>"><i class="fa fa-times"></i></a>
						<?php } ?>
					</div>
					<div id="review1">
						<div class=panel-body>
							<?php echo nl2br($review->getComment());

							if ($review->getReply()) { ?>
								<div class="alert alert-info top-pad" role="alert">
									<?php if (User::current()->isAdmin() || User::current()->getID() == $property->getSupplierID()) { ?>
										<a class="font-red close" href="./?property=<?php echo $property->getID(); ?>&deletereply=<?php echo $review->getConsumerID(); ?>"><i class="fa fa-times"></i></a>
									<?php } ?>
									<strong><?php echo $property->getSupplier()->getFirstName(); ?>:</strong> <?php echo nl2br($review->getReply()); ?></div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</div>

		<?php if (isset($_GET["reviewreply"])) { ?>

			<form action="" method="post">

				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<label for="commentreview">Reply to <?php echo $review->getConsumer()->getFirstName(); ?></label>
						<textarea class="form-control" id="commentreview" name="reply" required rows="5"></textarea>
					</div>
				</div>
				<div class="row">
					<input type="hidden" name="reviewReplySubmit">
					<div class="col-md-2 col-md-offset-5"><button class="btn lil-margin-top register-btn" type="submit">Reply</button></div>
				</div>

			</form>

		<?php }

	}

	$bookings = Booking::getAllForConsumer(User::current()->getID());
	$bookedThisPlace = false;
	foreach ($bookings as $booking) {
		if ($booking->getRentalPropertyID() == $property->getID()) {
			$bookedThisPlace = true;
		}
	}
	$alreadyReviewed = true;
	try {
		Review::getSingle(User::current()->getID(), $property->getID());
	} catch (Exception $e) {
		$alreadyReviewed = false;
	}

	if (!isset($_GET["reviewreply"])) {

		if (User::current()->getID() != $property->getSupplierID() && $bookedThisPlace && !$alreadyReviewed) { ?>

			<form action="" method="post">

				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<label for="commentreview">Write a review</label>
						<textarea class="form-control" id="commentreview" name="review" required rows="5"></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-md-offset-3"><strong>Rate Property</strong><br>
						(worst)&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="optradio" value="1">1</label>
						<label class="radio-inline"><input type="radio" name="optradio" value="2">2</label>
						<label class="radio-inline"><input type="radio" name="optradio" value="3" checked>3</label>
						<label class="radio-inline"><input type="radio" name="optradio" value="4">4</label>
						<label class="radio-inline"><input type="radio" name="optradio" value="5">5</label>
						&nbsp;&nbsp;(best)
					</div>
				</div>
				<div class="row">
					<input type="hidden" name="reviewAddSubmit">
					<div class="col-md-2 col-md-offset-5"><button class="btn lil-margin-top register-btn" type="submit">Submit</button></div>
				</div>

			</form>

		<?php }

	} ?>

</div>

<div class="huge-padding"></div>

<?php include "pages/footer.php";