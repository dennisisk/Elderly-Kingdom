<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/login.css">
		<link rel="stylesheet" type="text/css" href="css/profile.css">
		<title>Edit Account | Elderly Kingdom</title>
	</head>
	<body>
		<?php
			// If the edit btn is pressed, check the fields
			if(isset($_POST['edit-submit'])) { 
				require_once('dbconn.php');
				$pass = hash("sha256", $_POST['current-password']);
				$stmt = $pdo->query("SELECT login_pass FROM Users WHERE user_id=".$_SESSION['user_id']);
				while ($pw = $stmt->fetch(PDO::FETCH_ASSOC)){
					if ($pass == $pw['login_pass']) {
						if ($_POST['new-password'] !== $_POST['confirm-password']) {
							$case = 1;
						} else {
							$case = 2;
						}
						switch($case) {
							default: // Default case to throw exception
								echo '<script> $(document).ready(function(){
										$("#msg").addClass("alert alert-danger").attr("role", "alert");
										$("#msg").html("Unexpected error! Please contact Administrator.");
										setTimeout(function() { history.back() }, 3000);});</script>';
								break;
							case 1:	// Show "Two password not the same" alert message
								echo '<script> $(document).ready(function(){
										$("#msg").addClass("alert alert-danger").attr("role", "alert");
										$("#msg").html("Two passwords are not the same!");
										setTimeout(function() { history.back() }, 3000);});</script>';
								break;
							case 2: // All fields okay, proceed the UPDATE SQL process
								// Prepared statement to accept user inputs and prevent SQL injection
								$statement = $pdo->prepare("UPDATE Users SET login_pass =:login_pass WHERE user_id=".$_SESSION['user_id']);
								$hashpass = hash("sha256", $_POST['new-password']); // SHA-256 algorithm is used to hash the password
								$statement->execute(['login_pass' => $hashpass]);
								// Edit success and redirect user back
								echo '<script> $(document).ready(function(){
										$("#msg").addClass("alert alert-success").attr("role", "alert");
										$("#msg").html("Edited and saved successfully! Redirecting you to previous page.");
										setTimeout(function() { history.back() }, 3000);});</script>';
								break;
						}
					} else {
						// Show "Wrong Password" alert message
						echo '<script> $(document).ready(function(){
											$("#msg").addClass("alert alert-danger").attr("role", "alert");
											$("#msg").html("Wrong Password!");
											setTimeout(function() { history.back() }, 3000);});</script>';
					}
				}	
				include_once("header.php");
			} else {
				echo "<script> history.back();</script>";	
			}
		?>
		<div class="centerdiv">
			<div class="row1">
				<div class="breadcrumb-bar">
					<ol class="breadcrumb">
						<li><a href="index.php">Elderly Kingdom</a></li>
						<li class="active">Edit Account</li>
					</ol>
				</div>
			</div>
			<div class="row2">
				<div class="col-md-12">
					<div class="profile-content">
						<div id="msg"></div>
					</div>
				</div>
			</div>
	</body>
</html>