<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/profile.css">
		<title>Profile | Elderly Kingdom</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<?php 
		// Check Login
		if (isset($_SESSION['user_id'])) {
		include_once("header.php"); ?>
		<div class="centerdiv">
			<div class="row1">
				<div class="breadcrumb-bar">
					<ol class="breadcrumb">
						<li><a href="index.php">Elderly Kingdom</a></li>
						<li class="active">Profile</li>
					</ol>
				</div>
			</div>
			<div class="row2">
				<?php
					include_once("dbconn.php");
					// Validate GET value
					if (preg_match('/^\d+$/', $_GET['id'])){
					$profile_stmt = $pdo->query("SELECT login_id, email, case user_type WHEN 0 THEN 'admin' WHEN 1 THEN 'member' END AS user_type FROM Users WHERE user_id=".$_GET['id']);
					$profile = $profile_stmt->fetch(PDO::FETCH_ASSOC);	
					$history_stmt = $pdo->query("SELECT topic_id, subject, topic_date, cat_id, replies, views FROM Topics WHERE user_id=".$_GET['id']." ORDER BY topic_date DESC");
					}
					// Check if there is the corresponding user in DB
					if (!preg_match('/^\d+$/', $_GET['id']) || $profile_stmt->rowCount() == 0){ 
				?>
				<div class="col-md-12">
					<div class="profile-content">
						<div class="alert alert-warning" role="alert">No user found. Please try again.</div>
					</div>
				</div>
				<?php } else { ?>
				<!-- Sidebar Menu -->
				<div class="col-xs-12 col-md-3">
					<div class="profile-sidebar">
						<div class="profile-userpic">
							<img src="img/ek_user.png" id="icon" alt="usericon">
						</div>
						<div class="profile-usertitle">
							<div class="profile-usertitle-name">
								<?php echo $profile['login_id']; ?>
							</div>
							<div class="profile-usertitle-job">
								<?php echo $profile["user_type"]; ?>
							</div>
						</div>
						<div class="profile-usermenu">
							<ul class="nav">
								<li class="active">
									<a data-toggle="tab" href="#overview">
									<span class="glyphicon glyphicon-home"></span>
									Overview </a>
								</li>
								<?php //Check if the profile is owned by the current login user
									if ($_GET['id'] == $_SESSION['user_id']){ ?>
								<li>
									<a data-toggle="tab" href="#account">
									<span class="glyphicon glyphicon-user"></span>
									Account Settings </a>
								</li>
								<?php } ; ?>
							</ul>
						</div>
					</div>
				</div>
			<!-- Content Block -->
			<div class="col-xs-12 col-md-9">
				<div class="profile-content">
					<div class="tab-content">
						<!-- Overview -->
						<div class="tab-pane fade in active" id="overview">
							<!-- Contact -->
							<div class="panel panel-default">
								<div class="panel-heading"><h4><span class="glyphicon glyphicon-envelope"></span> Contact</h4></div>
								<div class="panel-body">Email: <?php echo $profile['email']; ?> </div>
							</div>
							<!-- Forum History -->
							<div class="panel panel-info">
								<div class="panel-heading"><h4><span class="glyphicon glyphicon-comment"></span> Forum History</h4></div>
								<div class="panel-body">
									
									<?php	
										while ($history = $history_stmt->fetch(PDO::FETCH_ASSOC)){ // Fetch data into the array
										$cat_stmt = $pdo->query('SELECT cat_name FROM Categories WHERE cat_id="'.$history['cat_id'].'"');
										$cat = $cat_stmt->fetch(PDO::FETCH_ASSOC);
										$like_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Likes WHERE topic_id='.$history['topic_id']);
										$like = $like_stmt->fetch(PDO::FETCH_ASSOC);
										$dislike_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Dislikes WHERE topic_id='.$history['topic_id']);
										$dislike = $dislike_stmt->fetch(PDO::FETCH_ASSOC);
										$reply_stmt = $pdo->query('SELECT COUNT(*) FROM Replies WHERE topic_id='.$history['topic_id']);
										$reply = $reply_stmt->fetch(PDO::FETCH_ASSOC);
									?>
	
									<a href="viewtopic.php?id=<?php echo $history["topic_id"];?>" class="list-group-item">
										<div class="row">
											<div class="col col-7 col-md-7 col-lg-7"><b>[<?php echo $cat["cat_name"];?>]<?php echo $history["subject"];?></b><br><span class="glyphicon glyphicon-thumbs-up"></span> <?php echo $like['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<span class="glyphicon glyphicon-thumbs-down"></span> <?php echo $dislike['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
											<div class="col col-3 col-md-3 col-lg-3"><span class="glyphicon glyphicon-time"></span> <?php echo $history['topic_date'];?><br></div>
											<div class="col col-2 col-md-2 col-lg-2"><span class="glyphicon glyphicon-comment"></span> <?php echo $reply['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<span class="glyphicon glyphicon-eye-open"></span> <?php echo $history['views'];?></div>
										</div>
									</a>
									<?php }
									// Check if there is any record of forum topics made by the user
									if ($history_stmt->rowCount() == 0){
									?>
										This user has no activity in forum.
									<?php } ?>
								</div>
							</div>
						</div>
						<?php //Check if the profile is owned by the current login user
							if ($_GET['id'] == $_SESSION['user_id']){ ?>
						<!-- Account Settings -->
						<div class="tab-pane fade" id="account">
							<!-- Edit Account -->
							<div class="panel panel-primary">
								<div class="panel-heading"><h4><span class="glyphicon glyphicon-pencil"></span> Edit Account</h4></div>
								<div class="panel-body">
									<form id="change-form" action="edituser.php" method="post" role="form">
										<div class="form-group">
											<input type="password" name="current-password" tabindex="1" class="form-control" placeholder="Current Password" required="required" autocomplete="off">
										</div>
										<div class="form-group">
											<input type="password" name="new-password" tabindex="2" class="form-control" placeholder="New Password" required="required" autocomplete="off">
										</div>
										<div class="form-group">
											<input type="password" name="confirm-password" tabindex="3" class="form-control" placeholder="Confirm New Password" required="required" autocomplete="off">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6 col-xs-offset-3">
													<input type="submit" name="edit-submit" id="edit-submit" tabindex="4" class="form-control btn btn-info" value="Edit and Save">
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!-- Delete Account -->
							<div class="panel panel-danger">
								<div class="panel-heading"><h4><span class="glyphicon glyphicon-trash"></span> Account Deletion</h4></div>
								<div class="panel-body">
									<form action="deleteuser.php" method="post">
										<p>If you <b>REALLY</b> want to delete your account, please confirm by verifying again.</p>
										<div class="form-group">
											<input type="text" name="username" tabindex="5" class="form-control" placeholder="Username" required="required" autocomplete="off">
										</div>
										<div class="form-group">
											<input type="password" name="password" tabindex="6" class="form-control" placeholder="Password" required="required" autocomplete="off">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-xs-6 col-xs-offset-3">
													<input type="submit" name="login-submit" id="login-submit" tabindex="7" class="form-control btn btn-danger" value="Delete">
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
			</div>
		</div>
		<?php 
			}}else {
				// Redirect to the login page
				echo "<script> window.location.href = 'login.php';</script>";
			} 
		?>
	</body>
</html>