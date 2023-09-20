<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<?php include_once("dependency.php"); ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<img class="logo" src="img/ek_logo.png">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/index.php") echo 'class="active" '; ?>><a href="index.php">Home</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/aging.php") echo 'class="active" '; ?>><a href="aging.php">What is Aging?</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/prevention.php") echo 'class="active" '; ?>><a href="prevention.php">Wander Prevention</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/caregiving.php") echo 'class="active" '; ?>><a href="caregiving.php">Caregiver Tips</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/serviceinfo.php") echo 'class="active" '; ?>><a href="serviceinfo.php">Service & Info</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/aboutus.php") echo 'class="active" '; ?>><a href="aboutus.php">About Us</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/forum.php" || $_SERVER['PHP_SELF'] == "/GP/viewtopic.php" || $_SERVER['PHP_SELF'] == "/GP/createtopic.php") echo 'class="active" '; ?>><a href="forum.php?id=0">Forum</a></li>
				<li <?php if ($_SERVER['PHP_SELF'] == "/GP/categories.php") echo 'class="active" '; ?>><a href="categories.php">Forum Categories</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<!-- If User has login, show member name and a dropdown menu -->
				<?php if (isset($_SESSION['login_id'])) { ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['login_id']; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu animated fadeIn" role="menu">
						<li><a role="menuitem" href="profile.php?id=<?php echo $_SESSION['user_id'] ?>" class="dropdown-item"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Profile</a></li>
						<li><a role="menuitem" href="logout.php" class="dropdown-item"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
					</ul>
				</li>
				<?php } else { ?>
				<!-- Show Register and Login button if user has not login -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Register <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-lr animated fadeIn" role="menu">
						<div class="col-lg-12">
							<div class="text-center">
								<h3><b>Register</b></h3>
							</div>
							<!-- Register Form -->
							<form id="register-form" action="register.php" method="post" role="form">
								<div class="form-group">
									<input type="text" name="username" tabindex="1" class="form-control" placeholder="Username" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<input type="email" name="email" tabindex="2" class="form-control" placeholder="Email Address" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<input type="password" name="password" tabindex="3" class="form-control" placeholder="Password" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<input type="password" name="confirm-password" tabindex="4" class="form-control" placeholder="Confirm Password" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xs-6 col-xs-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="5" class="form-control btn btn-info" value="Register">
										</div>
									</div>
								</div>
							</form>
						</div>
					</ul>
				</li>
				<!-- Login Button -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in <span class="caret"></span></a>
					<ul class="dropdown-menu dropdown-lr animated fadeIn" role="menu">
						<div class="col-lg-12">
							<div class="text-center">
								<h3><b>Sign in</b></h3>
							</div>
							<!-- Login Form -->
							<form id="login-form" action="login.php" method="post" role="form">
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" name="username" tabindex="1" class="form-control" placeholder="Username" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" tabindex="2" class="form-control" placeholder="Password" required="required" autocomplete="off">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xs-7">
											<a href="forgetpass.php" tabindex="4" class="forgot-password">Forgot Password?</a>
										</div>
										<div class="col-xs-5 pull-right">
											<input type="submit" name="login-submit" tabindex="3" class="form-control btn btn-success" value="Sign in">
										</div>
									</div>
								</div>
							</form>
						</div>
					</ul>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>