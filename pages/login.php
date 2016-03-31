<?php

$email = "";
$password = "";

if (isset($_POST["loginSubmit"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];
	if (Validate::email($email)) {
		$loggedIn = Session::login($_POST["email"], $_POST["password"]);
		if ($loggedIn) {
			if ($_SERVER["QUERY_STRING"]) {
				Session::redirect("./?" . $_SERVER["QUERY_STRING"]);
			} else {
				Session::redirect("./");
			}
		}
	}
}

?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Queen's Connect</title>

	<!-- Bootstrap -->
	<link href="qbnb_website/css/bootstrap.min.css" rel="stylesheet">
	<link href="qbnb_website/css/style.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

<div class="fullscreen background parallax" style="background-image:url('qbnb_website/images/bg.jpg');" data-img-width="1600" data-img-height="1064" data-diff="100">

	<div class="intro-text">
		<img class="intro-logo" id="logo" src="qbnb_website/images/logo.png">
		<h1 class="intro-title">Queen’s Connect</h1>
		<h2 class="intro-subtext">Explore the world through Queen's alumni.</h2>
	</div>

	<div class="login-box">
		<form class="form-group" method="post" action="">
			<label class="sr-only" for="username">Username</label>
			<input type="email" id="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">

			<label class="sr-only" for="password">Password</label>
			<input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">

			<input type="hidden" name="loginSubmit">
			<button type="submit" class="btn login-btn">login</button>

			<a class="btn register-btn" href="./?register">register</a>
		</form>
	</div>

</div>

</body>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/parallax.js"></script>
</body>

</html>