<html>
	<head>
	<link rel="stylesheet" href="css/index.css">
		<title>Index | Elderly Kingdom</title>
		
	</head>
	<body>
		<?php include_once("header.php");
		include_once("dbconn.php");
		?>
		<div class="container-fluid text-center">
		<h2>Trending in this week:</h2>
		 <div class="row">
		 <?php
		$forum_stmt = $pdo->query('SELECT * FROM Topics t, Categories c, Users u WHERE t.cat_id = c.cat_id AND t.user_id = u.user_id ORDER BY views desc LIMIT 6');
		while ($forum = $forum_stmt->fetch(PDO::FETCH_ASSOC)){
		//SELECT * FROM Topics t, Categories c WHERE t.cat_id = c.cat_id ORDER BY views desc LIMIT 2
		?>
		<div class="col-sm-4">
		<a href="viewtopic.php?id=<?php echo $forum["topic_id"];?>"><h2><?php echo $forum["subject"];?></h2></a>
		<div class="desc">
		<h4><b>In: [<?php echo $forum["cat_name"];?>]</b></h4>
		</div>
		<div class="item">
		<p>Author: <?php echo $forum["login_id"];?></p>
		</div>
		</div>
		<?php }	?>		
		</div>
		</div>
		<?php include("footer.php"); ?>
	</body>
</html>