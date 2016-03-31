<?php

if (!User::current()->isAdmin()) {
	Session::redirect("./");
}

include "pages/header.php";

$bannerText = "Administration";
include "pages/banner.php"; ?>

<?php

include "pages/footer.php";