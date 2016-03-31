<?php

include "pages/header.php";

$bannerText = "Hello, " . User::current()->getFirstName();
include "pages/banner.php"; ?>

<div class="huge-padding"></div>

<h3 style="text-align: center; margin-top: 0; margin-bottom: 1em">Bookings on My Properties</h3>

<?php include "pages/_supplierbookings.php"; ?>

<h3 style="text-align: center; margin-bottom: 1em">My Bookings</h3>

<?php include "pages/_consumerbookings.php";

include "pages/footer.php";