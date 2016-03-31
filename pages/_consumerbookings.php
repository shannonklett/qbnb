<div class="container">

<table class="table table-striped">
	<thead>
	<tr>
		<th>Property Name</th>
		<th>Property Owner</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Status</th>
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
	</tr>
	<?php } ?>
	</tbody>
</table>

</div>