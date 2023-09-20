<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<title>Password Reset | Elderly Kingdom</title>
	</head>
	<body>
		<?php
			// If the login btn is pressed, check the username and password
			if(isset($_POST['login-submit'])) { 
				require_once('dbconn.php');
				$pass = hash("sha256", $_POST['password']);
				$stmt = $pdo->query("SELECT user_id, login_id, login_pass, user_type FROM Users");
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					if ($_POST['username'] == $row['login_id'] && $pass == $row['login_pass']) {
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['login_id'] = $row['login_id'];
						$_SESSION['user_type'] = $row['user_type'];
						echo "<script> window.location.href = 'index.php';</script>";
					} else {
						echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Wrong Username or Password!");
											});</script>';
					}
				}
			}
			?>
		<div class="login-form">
			<!-- Self validating using the same PHP page, so no unnecessary extra PHP page is used. -->
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
				<!-- htmlentities() is used to prevent XSS exploit -->
				<div class="clearfix">
					<a href="index.php" class="pull-left" title="Go back"><span class="glyphicon glyphicon-menu-left"></span></a>
				</div>
				<h2 class="text-center">Password Reset</h2>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" name="email" class="form-control" placeholder="Email" required="required">
					</div>
				</div>
				<div class="form-group" id="msg"></div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary btn-block" name="reset-submit" value="Submit">
				</div>
			</form>
			<p class="text-center small">Don't have an account? <a href="register.php">Sign up here</a>.</p>
		</div>
	</body>
</html>