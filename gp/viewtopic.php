<?php if (session_status() == PHP_SESSION_NONE) { session_start();}
include_once("dbconn.php");
$topic_stmt = $pdo->query('SELECT subject, content, topic_date, user_id, cat_id, views FROM Topics WHERE topic_id="'.$_GET['id'].'"');
$topic = $topic_stmt->fetch(PDO::FETCH_ASSOC); // Fetch data into the array
$newviews = $topic['views'] + 1; // When someone open this page, the view of the topic increase by 1
$statement = $pdo->prepare('UPDATE Topics SET views=:views WHERE topic_id="'.$_GET['id'].'"');
$statement->execute(['views' => $newviews]);
$user_stmt = $pdo->query('SELECT login_id FROM Users WHERE user_id='.$topic['user_id']);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
$cat_stmt = $pdo->query('SELECT cat_name FROM Categories WHERE cat_id='.$topic['cat_id']);
$cat = $cat_stmt->fetch(PDO::FETCH_ASSOC);
$like_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Likes WHERE topic_id='.$_GET['id']);
$like = $like_stmt->fetch(PDO::FETCH_ASSOC);
$dislike_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Dislikes WHERE topic_id='.$_GET['id']);
$dislike = $dislike_stmt->fetch(PDO::FETCH_ASSOC);
$reply_stmt = $pdo->query('SELECT reply_id, content, reply_date, user_id FROM Replies WHERE topic_id="'.$_GET['id'].'" ORDER BY reply_date');
?>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/forum.css">
		<title>[<?php echo $cat["cat_name"];?>]<?php echo $topic["subject"];?> | Elderly Kingdom</title>
	</head>
	<body>
		<?php if (isset($_SESSION['user_id'])) {
		include_once("header.php"); ?>
		<div class="row1">
			<div class="breadcrumb-bar">
				<ol class="breadcrumb">
					<a href="#" onclick="history.back();" title="Go back"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
					<li><a href="index.php">Elderly Kingdom</a></li>
					<li><a href="forum.php">Forum</a></li>
					<li class="active">[<?php echo $cat["cat_name"];?>]<?php echo $topic["subject"];?></li>
				</ol>
			</div>
			<div class="main">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">[<?php echo $cat['cat_name'];?>]<?php echo $topic['subject'];?></h3>
						<span class="glyphicon glyphicon-user"></span> <?php echo $user['login_id'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="glyphicon glyphicon-time"></span> <?php echo $topic['topic_date'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="glyphicon glyphicon-eye-open"></span> <?php echo $newviews ;?>
					</div>
					<div class="panel-body">
						<?php echo $topic['content'];?>
						<div class="panel-body">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-sm button-round"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <?php echo $like['COUNT(*)'];?> </button> 
								<button type="button" class="btn btn-default btn-sm button-round"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> <?php echo $dislike['COUNT(*)'];?> </button>
							</span>
						</div>
					</div>
				</div>
				<?php
				while ($reply = $reply_stmt->fetch(PDO::FETCH_ASSOC)){
					$replyuser_stmt = $pdo->query('SELECT login_id FROM Users WHERE user_id="'.$reply['user_id'].'"');
					$replyuser = $replyuser_stmt->fetch(PDO::FETCH_ASSOC);
				?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="glyphicon glyphicon-user"></span> <?php echo $replyuser['login_id']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span class="glyphicon glyphicon-time"></span> <?php echo $reply['reply_date']; ?>
						</div>
						<div class="panel-body"><?php echo $reply['content']; ?></div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } else {
			echo "<script> window.location.href = 'login.php';</script>";
			} ?>
	</body>
</html>