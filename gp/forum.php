<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<html>
	<head>
		<?php include_once("dependency.php"); ?>
		<link rel="stylesheet" type="text/css" href="css/forum.css">
		<title>Forum | Elderly Kingdom</title>
	</head>
	<body>
		<?php include_once("header.php"); ?>
		<div class="centerdiv">
			<div class="row1">
				<div class="breadcrumb-bar">
					<ol class="breadcrumb">
						<li><a href="index.php">Elderly Kingdom</a></li>
						<li class="active">Forum</li>
					</ol>
				</div>
			</div>
			<div class="row2">
				<div class="main">
					<div class="list-group">
						<?php
							include_once("dbconn.php");
							$id = $_GET["id"];
							if ($id != 0){ 
							$forum_stmt = $pdo->query('SELECT topic_id, subject, topic_date, user_id, cat_id, replies, views FROM Topics WHERE cat_id =' .$id.' ORDER BY topic_date DESC' );//"ORDER BY topic_date DESC;");
							}else{
								$forum_stmt = $pdo->query('SELECT topic_id, subject, topic_date, user_id, cat_id, replies, views FROM Topics ORDER BY topic_date DESC');
							}
							while ($forum = $forum_stmt->fetch(PDO::FETCH_ASSOC)){ // Fetch data into the array
								$cat_stmt = $pdo->query('SELECT cat_name FROM Categories WHERE cat_id="'.$forum['cat_id'].'"');
								$cat = $cat_stmt->fetch(PDO::FETCH_ASSOC);
								$user_stmt = $pdo->query('SELECT login_id FROM Users WHERE user_id='.$forum['user_id']);
								$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
								$like_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Likes WHERE topic_id='.$forum['topic_id']);
								$like = $like_stmt->fetch(PDO::FETCH_ASSOC);
								$dislike_stmt = $pdo->query('SELECT COUNT(*) FROM Topic_Dislikes WHERE topic_id='.$forum['topic_id']);
								$dislike = $dislike_stmt->fetch(PDO::FETCH_ASSOC);
								$reply_stmt = $pdo->query('SELECT COUNT(*) FROM Replies WHERE topic_id='.$forum['topic_id']);
								$reply = $reply_stmt->fetch(PDO::FETCH_ASSOC);
								?>
								<a href="viewtopic.php?id=<?php echo $forum["topic_id"];?>" class="list-group-item">
									<div class="row">
										<div class="col col-7 col-md-7 col-lg-7"><b>[<?php echo $cat["cat_name"];?>]<?php echo $forum["subject"];?></b><br><span class="glyphicon glyphicon-user"></span> <?php echo $user['login_id'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span> <?php echo $like['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="glyphicon glyphicon-thumbs-down"></span> <?php echo $dislike['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="col col-3 col-md-3 col-lg-3"><span class="glyphicon glyphicon-time"></span> <?php echo $forum['topic_date'];?><br></div>
										<div class="col col-2 col-md-2 col-lg-2"><span class="glyphicon glyphicon-comment"></span> <?php echo $reply['COUNT(*)'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<span class="glyphicon glyphicon-eye-open"></span> <?php echo $forum['views'];?></div>
										
										
										
										
										
										
									</div>
								</a>
							<?php }	;?>
					</div>
				</div>
				<div class="side">
					<a href="createtopic.php" class="btn btn-info btn-block"><span class='glyphicon glyphicon-comment' aria-hidden='true'></span> New Topic</a> <br>
					<h2 align="center">討論分類</h2>
					<div class="grid-container">
						<div class="grid-item"><a href="forum.php?id=0">不分類</a></div>
						<div class="grid-item"><a href="forum.php?id=1">測試</a></div>
						<div class="grid-item"><a href="forum.php?id=2">健康飲食</a></div>  
						<div class="grid-item"><a href="forum.php?id=3">保健討論</a></div>
						<div class="grid-item"><a href="forum.php?id=4">照顧老人</a></div>
						<div class="grid-item"><a href="forum.php?id=5">網絡醫生</a></div>  
						<div class="grid-item"><a href="forum.php?id=6">老人聊天室</a></div>
						<div class="grid-item"><a href="forum.php?id=7">養老心得</a></div>
						<div class="grid-item"><a href="forum.php?id=30">雜項</a></div> 
					</div>
				</div>
			</div>
		</div>
	</body>
</html>