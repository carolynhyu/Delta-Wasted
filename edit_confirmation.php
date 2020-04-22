<?php
	require "config/config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	$email = $_SESSION['user_email'];
	$password = $_SESSION['user_password'];

	$sql_table = "SELECT * FROM users WHERE user_email='$email' AND user_password='$password';";
	$results_table = $mysqli->query($sql_table);
	$row = $results_table->fetch_assoc();

	// $mysqli->close();
	if ( empty($_POST['current_psw']) || empty($_POST['new_psw']) ){
			//create new variable $error
			$error = "Please fill out both current password and new password.";
	} else if ( $_POST['current_psw'] == $_POST['new_psw']){
			$error = "New password can't be the same as existing password.";
	} else if ( $_POST['current_psw'] != $row['user_password']){
			$error = "Wrong current password.";
	}
	else {
		// require "config/config.php";

		$password_current = $_POST['current_psw'];
        $password = $_POST['new_psw'];

		$sql = "UPDATE users
				SET users.user_password = '$password'
				WHERE users.user_id = " . $_POST['user_id'] . ";";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $sql . "<br>";
			echo $mysqli->error;
			echo $_POST['user_id'];
			echo $password;
			$mysqli->close();
			exit();
		}

		$_SESSION['user_password'] = $password;

		//4. Close DB connection
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | New Password</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<!-- <div class="container"> -->
		<!-- <div class="row">
			<h1 class="col-12 mt-4">Edit a Football Game</h1>
		</div> .row -->
	<!-- </div>  -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<?php if(!empty($error)): ?>

				<div class="text-danger">
					<?php echo $error ?>
				</div>

			<?php else : ?>
				
				<div class="text-success">
					Password was successfully updated.
				</div>	

			<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="account_page.php" role="button" class="btn btn-primary">Go back to Account Page</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>