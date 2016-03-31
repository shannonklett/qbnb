<?php

include "pages/header.php";

$bannerText = "Hello, " . User::current()->getFirstName();
include "pages/banner.php"; ?>

<h3 style="text-align: center">Bookings on My Properties</h3>
<h3 style="text-align: center">My Bookings</h3>

<?php


//include "pages/_mybookings.php";

include "pages/footer.php";