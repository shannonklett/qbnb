<div class="container">

	<?php $myBookings = Booking::getAllForConsumer(User::current()->getID());

	if (count($myBookings) == 0) { ?>

		<div class="alert alert-danger" role="alert"> <strong>Oh snap!</strong> Looks like you don't have any bookings! <a href="./?search">Go hunt</a>!</div>

	<?php } else { ?>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>Property Name</th>
				<th>Property Owner</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Status</th>
				<th>Cancel</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach (Booking::getAllForConsumer(User::current()->getID()) as $booking) {
				$property = $booking->getRentalProperty();
				?>
				<tr>
					<td><a href="./?property=<?php echo $property->getID(); ?>"><?php echo $property->getName(); ?></a></td>
					<td><?php echo $property->getSupplier()->getFullName(); ?></td>
					<td><?php echo $booking->getStartDate()->format(Format::DATE_FORMAT); ?></td>
					<td><?php echo $booking->getEndDate()->format(Format::DATE_FORMAT); ?></td>
					<td><?php echo $booking->getStatus(); ?></td>
					<td><a class="font-red" href="./?property=<?php echo $property->getID(); ?>&cancelbooking=<?php echo $booking->getID(); ?>"><i class="fa fa-times"></i></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	<?php } ?>

</div>