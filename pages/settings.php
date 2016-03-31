<?php

$success = "";

if (isset($_POST["settingsSubmit"])) {

	if (Validate::email($_POST["email"]) && Validate::phone($_POST["phone"]) && Validate::int($_POST["graduation"])) {
		User::current()->setFirstName($_POST["firstname"]);
		User::current()->setLastName($_POST["lastname"]);
		User::current()->setEmail($_POST["email"]);
		User::current()->setPhoneNumber($_POST["phone"]);
		User::current()->setGradYear($_POST["graduation"]);
		User::current()->setFacultyID($_POST["faculty"]);
		User::current()->setDegreeTypeID($_POST["degreetype"]);
		User::current()->setGender($_POST["gender"]);
		$success = User::current()->update();

		if ($success && $_POST["password"]) {
			User::current()->setPassword($_POST["password"]);
			$success = User::current()->update();
		}
	}

}

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

		<?php if ($success) { ?>

			<div class="alert alert-success" role="alert"> <strong>Great job!</strong> You successfully updated your settings! </div>

		<?php } else {
			echo $success;
		} ?>

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="fname">First Name</label>
				<input class="form-control" type="text" id="fname" name="firstname" value="<?php echo User::current()->getFirstName(); ?>" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="lname">Last Name</label>
				<input class="form-control" type="text" id="lname" name="lastname" value="<?php echo User::current()->getLastName(); ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="useremail">Email</label>
				<input class="form-control" type="email" id="useremail" name="email" value="<?php echo User::current()->getEmail(); ?>" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userphone">Phone Number</label>
				<input class="form-control" type="tel" id="userphone" name="phone" value="<?php echo User::current()->getPhoneNumber(); ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-md-offset-2" style="padding-top: 0;">
				<label for="gradyear">Graduation Year</label>
				<input class="form-control" type="number" id="gradyear" name="graduation" value="<?php echo User::current()->getGradYear(); ?>" required>
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userfaculty">Faculty</label>
				<select class="form-control select-search-form" name="faculty" id="userfaculty">
					<?php foreach (User::getFaculties() as $id => $faculty) { ?>
						<option value="<?php echo $id; ?>" <?php if ($id == User::current()->getFacultyID()) echo 'selected'; ?>><?php echo $faculty; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2" style="padding-top: 0;">
				<label for="userdegree">Degree Type</label>
				<select class="form-control select-search-form" name="degreetype" id="userdegree">
					<?php foreach (User::getDegreeTypes() as $id => $type) { ?>
						<option value="<?php echo $id; ?>" <?php if ($id == User::current()->getDegreeTypeID()) echo 'selected'; ?>><?php echo $type; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2" style="padding-bottom: 2em">
				<label for="usergender">Gender</label>
				<input class="form-control" type="text" id="usergender" name="gender" value="<?php echo User::current()->getGender(); ?>" required>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-2" style="padding-top: 0;">
				<label for="userpass">Change Password</label>
				<input class="form-control" type="password" id="userpass" name="password">
			</div>
			<div class="col-md-4" style="padding-top: 0;">
				<label for="userpass2">Confirm Password</label>
				<input class="form-control" type="password" id="userpass2" name="password2">
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2" style="text-align: center">
				<input type="hidden" name="settingsSubmit">
				<button type="submit" class="btn register-btn">Save Changes</button>
				<a href="./?deleteuser=<?php echo User::current()->getID(); ?>" class="btn btn-danger">Cancel Membership</a>
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