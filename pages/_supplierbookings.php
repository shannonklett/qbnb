<div class="container">

	<?php
	$bookings = [];
	foreach (RentalProperty::getAllForSupplier(User::current()->getID()) as $property) {
		foreach (Booking::getAllForProperty($property->getID()) as $booking) {
			$bookings[] = $booking;
		}
	}

	if (count($bookings) == 0) {

		if (count(RentalProperty::getAllForSupplier(User::current()->getID())) == 0) { ?>

			<div class="alert alert-danger" role="alert"> <strong>Hey you!</strong> You don't have any properties listed! Consider <a href="./?myproperties">listing some</a>? </div>

		<?php } else { ?>

			<div class="alert alert-danger" role="alert"> <strong>Hey you!</strong> No one's booked your properties yet. Try <a href="./?myproperties">working on their profiles</a>?</div>

		<?php } ?>

	<?php } else { ?>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>Property Name</th>
				<th>Booked By</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Status</th>
				<th>Confirm/Reject</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($bookings as $booking) { ?>
				<tr>
					<td><a href="./?property=<?php echo $property->getID(); ?>"><?php echo $property->getName(); ?></a></td>
					<td><?php echo $booking->getConsumer()->getFullName(); ?></td>
					<td><?php echo $booking->getStartDate()->format(Format::DATE_FORMAT); ?></td>
					<td><?php echo $booking->getEndDate()->format(Format::DATE_FORMAT); ?></td>
					<td><?php echo $booking->getStatus(); ?></td>
					<td>
					<?php if ($booking->getStatusID() == 1) { ?>
						<a class="font-green" href="./?property=<?php echo $property->getID(); ?>&confirmbooking=<?php echo $booking->getID(); ?>"><i class="fa fa-check"></i></a> <a class="font-red" href="./?property=<?php echo $property->getID(); ?>&rejectbooking=<?php echo $booking->getID(); ?>"><i class="fa fa-times"></i></a>
					<?php } ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	<?php } ?>

</div>