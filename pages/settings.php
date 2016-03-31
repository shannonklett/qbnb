<?php

include "pages/header.php"; ?>

<!DOCTYPE html>
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
	<link href="qbnb_website/css/font-awesome.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body data-target=".navbar-fixed-top">
<?php $bannerText = "Settings";
include "pages/banner.php"; ?>

<div class="container">

	<div class="huge-padding"></div>

	<form action="" method="post">

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="fname">First Name</label>
				<input class="form-control" type="text" id="fname" name="firstname" value="gg" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="lname">Last Name</label>
				<input class="form-control" type="text" id="lname" name="lastname" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="useremail">Email</label>
				<input class="form-control" type="email" id="useremail" name="email" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userphone">Phone Number</label>
				<input class="form-control" type="tel" id="userphone" name="phone" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="userpass">Password</label>
				<input class="form-control" type="password" id="userpass" name="password" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userpass">Confirm Password</label>
				<input class="form-control" type="password" id="userpass" name="password" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-2" style="padding-top: 0;">
				<label for="gradyear">Graduation Year</label>
				<input class="form-control" type="number" id="gradyear" name="graduation" value="2016" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userfaculty">Faculty</label>
				<select class="form-control select-search-form" name="faculty" id="userfaculty">
					<?php foreach (User::getFaculties() as $id => $faculty) { ?>
						<option value="<?php echo $id; ?>"><?php echo $faculty; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2" style="padding-top: 0;">
				<label for="userdegree">Degree Type</label>
				<select class="form-control select-search-form" name="degreetype" id="userdegree">
					<?php foreach (User::getDegreeTypes() as $id => $type) { ?>
						<option value="<?php echo $id; ?>"><?php echo $type; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2" style="padding-bottom: 2em">
				<label for="usergender">Gender</label>
				<input class="form-control" type="text" id="usergender" name="gender" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 col-md-offset-2">
				<input type="hidden" name="settingsSubmit">
				<button type="submit" class="btn register-btn">Save Changes</button>
			</div>
			<div class="col-md-3">
				<button name="cancelMembership" class="btn register-btn">Cancel Membership</button>
			</div>
		</div>
	</form>

	<div class="huge-padding"></div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="qbnb_website/js/jquery-1.10.2.min.js"></script>
<script src="qbnb_website/js/bootstrap.min.js"></script>
<script src="qbnb_website/js/parallax.js"></script>
</body>

</html>

<?php

include "pages/footer.php";