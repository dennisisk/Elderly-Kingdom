<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<title>Register | Elderly Kingdom</title>
	</head>
	<body>
		<?php
			// If the register btn is pressed, check the fields
			if(isset($_POST['register-submit'])) { 
							// Check whether the username input is longer than 16 char
							if (strlen($_POST['username'])>16){
								$case = 1;
							//Check if the email address is valid or not
							} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
								$case = 2;
							// Check the two password the same or not
							} else if ($_POST['password'] !== $_POST['confirm-password']) {
								$case = 3;
							} else {
								require_once('dbconn.php');
								$stmt = $pdo->query("SELECT login_id, email FROM Users");
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
									// Check the new username exists or not
									if ($_POST['username'] == $row['login_id']) {
										$case = 4;
									// Check the email exists or not
									} else if ($_POST['email'] == $row['email']) {
										$case = 5;
									// All fields OK, pass to case 6 to handle the registration
									} else {
										$case = 6;
									}
								}
							}
							switch($case) {
								default: // Default case to throw exception
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Unexpected error! Please contact Administrator.");
											});</script>';
									break;
								case 1: // Show "Name too long" alert message
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Username exceeds 16 characters!");
											});</script>';
									break;
								case 2:	// Show "Wrong email" alert message
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Email is invalid!");
											});</script>';
									break;
								case 3:	// Show "Two password not the same" alert message
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Two passwords are not the same!");
											});</script>';
									break;
								case 4:	// Show "username exists" alert message
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Username already exists!");
											});</script>';
									break;
								case 5:	// Show "email exists" alert message
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Email already exists!");
											});</script>';
									break;
								case 6: // All fields okay, proceed the INSERT SQL process
									// Prepared statement to accept user inputs and prevent SQL injection
									$statement = $pdo->prepare('INSERT INTO Users (login_id, login_pass, email) VALUES (:login_id, :login_pass, :email)');
									$hashpass = hash("sha256", $_POST['password']); // SHA-256 algorithm is used to hash the password
									$statement->execute([
										'login_id' => $_POST['username'],
										'login_pass' => $hashpass,
										'email' => $_POST['email']
									]);
									// Reservation success and redirect user to index.php
									echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-success").attr("role", "alert");
											$("#msg").html("Registration success! Redirecting you to homepage.");
											setTimeout(function() { window.location.href = "index.php" }, 5000);
											});</script>';
									$stmt = $pdo->prepare("SELECT user_id, login_id, user_type FROM Users WHERE login_id=:login_id");
									$stmt->execute(['login_id' => $_POST['username']]); 
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
									$_SESSION['user_id'] = $row['user_id'];
									$_SESSION['login_id'] = $row['login_id'];
									$_SESSION['user_type'] = $row['user_type'];
									break;
							}
						}
			if (!isset($_SESSION['user_id'])) {
			?>
		<div class="login-form">
			<!-- Self validating using the same PHP page, so no unnecessary extra PHP page is used. -->
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
				<!-- htmlentities() is used to prevent XSS exploit -->
				<div class="clearfix">
					<a href="#" onclick="history.back();" title="Go back"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span></a>
				</div>
				<h2 class="text-center">Sign up</h2>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" name="username" class="form-control" placeholder="Username" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" name="email" class="form-control" placeholder="Email" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" name="password" class="form-control" placeholder="Password" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" required="required">
					</div>
				</div>
				<div id="msg"></div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary btn-block" name="register-submit" value="Register">
				</div>
			</form>
			<p class="text-center small">Already have an account? <a href="login.php">Sign in here</a>.</p>
		</div>
		<?php
			} else {
				echo "<script> history.back();</script>";
			}
			?>
	</body>
</html>