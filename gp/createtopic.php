<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<html lang="en">
	<head>
		<?php include_once("dependency.php"); ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css">
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/forum.css">
		<title>Create Topic | Elderly Kingdom</title>
	</head>
	<body>
		<?php if(isset($_POST['post'])) { 
			require_once('dbconn.php');
			if($_POST['defineCat']!=="" && $_POST['defineCatDesc']!==""){ // Check other or not
				$checkExist = $pdo->query("SELECT cat_name FROM Categories");
				while ($getCat = $checkExist->fetch(PDO::FETCH_ASSOC)){
					if ($_POST['defineCat'] == $getCat['cat_name']){// Check cat name exist or not
						$create = 0;
						break;
					} else {
						$create = 1;
					}
				}
				if ($create == 1){
					$stmt = $pdo->prepare("INSERT INTO Categories (cat_name, cat_desc) VALUES (:defineCat, :defineCatDesc)");
					$stmt->execute(['defineCat' => $_POST['defineCat'],
									'defineCatDesc' => $_POST['defineCatDesc']]);
				}
				$stmt2 = $pdo->prepare("SELECT cat_id FROM Categories WHERE cat_name = :defineCat");
				$stmt2->execute(['defineCat' => $_POST['defineCat']]);
				$getCat = $stmt2->fetch(PDO::FETCH_ASSOC);
				$cat_id = $getCat['cat_id'];
			} else {
				$cat_id = $_POST['cat'];
			}
			$topic_stmt = $pdo->prepare("INSERT INTO Topics (subject, content, topic_date, user_id, cat_id) VALUES (:subject, :content, :topic_date, :user_id, :cat_id)");
			$currentTimestamp = time();
			$currentTime = date('Y-m-d H:i:s', $currentTimestamp);
			$topic_stmt->execute(['subject' => $_POST['subject'],
								  'content' => $_POST['editor'],
								  'topic_date' => $currentTime,
								  'user_id' => $_SESSION['user_id'],
								  'cat_id' => $cat_id]);
			echo '<script> $(document).ready(function(){
					$("#msg").addClass("alert alert-success").attr("role", "alert");
					$("#msg").html("Post new topic success! Redirecting you to forum.");
					setTimeout(function() { window.location.href = "forum.php" }, 3000);});</script>';
			}
			if (isset($_SESSION['user_id'])) {
			include_once("header.php"); ?>
		<div class="centerdiv">
			<div class="row1">
				<div class="breadcrumb-bar">
					<ol class="breadcrumb">
						<a href="#" onclick="history.back();" title="Go back"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
						<li><a href="index.php">Elderly Kingdom</a></li>
						<li><a href="forum.php">Forum</a></li>
						<li class="active">Create Topic</li>
					</ol>
				</div>
			</div>
			<div class="row2">
				<div class="col-lg-12">
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
						<div class="form-group">
							<label for="cat">Category: </label>
							<select id="cat" name="cat" onchange="otherCat()">
								<?php 
									include_once("dbconn.php");
									$cat_stmt = $pdo->query('SELECT cat_id, cat_name FROM Categories');
									while ($cat = $cat_stmt->fetch(PDO::FETCH_ASSOC)){ // Fetch data into the array
										?>
								<option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name'] ?></option>
								<?php } ?>
								<option value="other">Others</option>
							</select>
							<input type="text" id="defineCat" name="defineCat" class="form-control" placeholder="Category" autocomplete="off">
							<input type="text" id="defineCatDesc" name="defineCatDesc" class="form-control" placeholder="Category Description" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="subject">Subject: </label>
							<input type="text" name="subject" class="form-control" placeholder="Subject" required="required" autocomplete="off">
						</div>
						<textarea name="editor" id="summernote"></textarea>
						<div id="msg"></div>
						<div class="form-group">
							<input type="submit" class="btn btn-info btn-block" name="post" value="Post">
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			function otherCat() {
				var x = document.getElementById("cat").value;
				if (x == "other"){
					$("#defineCat").show();
					$("#defineCatDesc").show();
					$("#defineCat").attr("required", "required");
					$("#defineCatDesc").attr("required", "required");
				} else {
					$("#defineCat").hide();
					$("#defineCatDesc").hide();
					$("#defineCat").removeAttr("required");
					$("#defineCatDesc").removeAttr("required");
				}
			}
			$(document).ready(function() {
				$('#defineCat').hide();
				$('#defineCatDesc').hide();
				$('#summernote').summernote({
					tabsize: 2,
			      		height: 300,
			    		});
			});
		</script>
		<?php } else {
			echo "<script> window.location.href = 'login.php';</script>";
			} ?>
	</body>
</html>