<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<html lang="en">
	<head>
		<?php include_once("dependency.php"); ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css">
		<link rel="stylesheet" type="text/css" href="css/header.css">
		<link rel="stylesheet" type="text/css" href="css/forum.css">
		<title>Replying topic | Elderly Kingdom</title>
	</head>
	<body>
		<?php if(isset($_POST['reply'])) { 
			require_once('dbconn.php');
			$currentTimestamp = time();
			$currentTime = date('Y-m-d H:i:s', $currentTimestamp);
			$stmt = $pdo->prepare("INSERT INTO Replies (content, reply_date, user_id, topic_id) VALUES (:content, :reply_date, :user_id, :topic_id)");
			$stmt->execute(['content' => $_POST['content'],
							'reply_date' => $currentTime,
							'user_id' => $_SESSION['user_id'],
							'topic_id' => $_GET['id']]);


			
			if (isset($_SESSION['user_id'])) {
			include_once("header.php"); ?>
		<div class="centerdiv">
			<div class="row1">
				<div class="breadcrumb-bar">
					<ol class="breadcrumb">
						<a href="#" onclick="history.back();" title="Go back"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
						<li><a href="index.php">Elderly Kingdom</a></li>
						<li><a href="forum.php">Forum</a></li>
						<li class="active">Reply Topic</li>
					</ol>
				</div>
			</div>
			<div class="row2">
				<div class="col-lg-12">
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
						<textarea name="editor" id="summernote"></textarea>
						<div id="msg"></div>
						<div class="form-group">
							<input type="submit" class="btn btn-info btn-block" name="reply" value="Reply">
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php } else {
			echo "<script> window.location.href = 'login.php';</script>";
			} ?>
	</body>
</html>