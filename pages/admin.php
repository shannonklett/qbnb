<?php

if (!User::current()->isAdmin()) {
	Session::redirect("./");
}

include "pages/header.php";

$bannerText = "Administration";
include "pages/banner.php"; ?>

<div class="huge-padding"></div>

<div class="container">
<div class="row">
    <ul id="myTabs" class="nav nav-tabs nav-justified" role="tablist">
        <li role="presentation" class="active"><a href="#users" id="users-tab" role="tab" data-toggle="tab" aria-controls="users" aria-expanded="true">System Users</a>
        </li>
        <li role="presentation"><a href="#propertysum" role="tab" id="propertysum-tab" data-toggle="tab" aria-controls="propertysum">Property Summary</a>
        </li>
        <li role="presentation"><a href="#suppliersummary" role="tab" id="suppliersummary-tab" data-toggle="tab" aria-controls="suppliersummary">Supplier Summary</a>
        </li>
        <li role="presentation"><a href="#consumersummary" role="tab" id="consumersummary-tab" data-toggle="tab" aria-controls="consumersummary">Consumer Summary</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="users" aria-labelledby="users-tab">
            <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>User Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Delete User?</strong></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach (User::getAll() as $user) { ?>
	          <tr>
		          <td><?php echo $user->getFullName(); ?></td>
		          <td><a href="mailto:<?php echo $user->getEmail(); ?>"><?php echo $user->getEmail(); ?></a></td>
		          <td><div><a class="font-red" href="./?deleteuser=<?php echo $user->getID(); ?>"><i class="fa fa-times"></i></a></div></td>
	          </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="propertysum" aria-labelledby="propertysum-tab">
            <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>Property Name</strong></th>
              <th><strong>Total Bookings</strong></th>
              <th><strong>Average Rating</strong></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach (RentalProperty::getAll() as $property) {
	          $ratings = [];
	          foreach (Review::getAllForProperty($property->getID()) as $review) {
		          $ratings[] = $review->getRating();
	          }
	          $numRatings = count($ratings);
	          if ($numRatings == 0) {
		          $propertyRating = "—";
	          } else {
		          $propertyRating = array_sum($ratings) / $numRatings;
	          }
	          ?>
	          <tr>
		          <td><a href="./?property=<?php echo $property->getID(); ?>"><?php echo $property->getName(); ?></a></td>
		          <td><?php echo count(Booking::getAllForProperty($property->getID())); ?></td>
		          <td><?php echo $propertyRating; ?></td>
	          </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="suppliersummary" aria-labelledby="suppliersummary-tab">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>User Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Total Bookings</strong></th>
              <th><strong>Average Rating</strong></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach (User::getAll() as $user) {
	          $bookings = [];
	          $ratings = [];
	          $properties = RentalProperty::getAllForSupplier($user->getID());
	          foreach ($properties as $property) {
		          foreach (Booking::getAllForProperty($property->getID()) as $booking) {
			          $bookings[] = $booking;
		          }
		          foreach (Review::getAllForProperty($property->getID()) as $review) {
			          $ratings[] = $review->getRating();
		          }
	          }
	          $numRatings = count($ratings);
	          if ($numRatings == 0) {
		          $supplierRating = "—";
	          } else {
		          $supplierRating = array_sum($ratings) / $numRatings;
	          }
	          ?>
	          <tr>
		          <td><?php echo $user->getFullName(); ?></td>
		          <td><a href="mailto:<?php echo $user->getEmail(); ?>"><?php echo $user->getEmail(); ?></a></td>
		          <td><?php echo count($bookings); ?></td>
		          <td><?php echo $supplierRating; ?></td>
	          </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="consumersummary" aria-labelledby="consumersummary-tab">
        <table class="table table-striped">
          <thead>
            <tr>
              <th><strong>User Name</strong></th>
              <th><strong>Email</strong></th>
              <th><strong>Requested Bookings</strong></th>
              <th><strong>Confirmed Bookings </strong></th>
              <th><strong>Rejected Bookings</strong></th>
            </tr>
          </thead>
          <tbody>
          <?php foreach (User::getAll() as $user) {
	          $bookings = Booking::getAllForConsumer($user->getID());
	          $requested = [];
	          $confirmed = [];
	          $rejected = [];
	          foreach ($bookings as $booking) {
		          if ($booking->getStatusID() == 1) {
			          $requested[] = $booking;
		          } else if ($booking->getStatusID() == 2) {
			          $confirmed[] = $booking;
		          } else if ($booking->getStatusID() == 3) {
			          $rejected[] = $booking;
		          }
	          } ?>
	          <tr>
		          <td><?php echo $user->getFullName(); ?></td>
		          <td><a href="mailto:<?php echo $user->getEmail(); ?>"><?php echo $user->getEmail(); ?></a></td>
		          <td><?php echo count($requested); ?></td>
		          <td><?php echo count($confirmed); ?></td>
		          <td><?php echo count($rejected); ?></td>
	          </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
    </div>  
</div>
</div>

<div class="huge-padding"></div>

<?php

include "pages/footer.php";