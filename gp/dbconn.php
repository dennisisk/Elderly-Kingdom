<?php
	try{
		$opt = array(PDO::ATTR_PERSISTENT => TRUE); // 'ATTR_PERSISTENT => TRUE' allow long-time connection to db
		$pdo = new PDO('mysql:host=localhost;port=3306;charset=utf8;dbname=spd4517_gp', 'ching', 'dllmcfh', $opt); // Connect to db
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException $e){ // Throw exception if error
		echo "Database connection error. ".$e->getMessage();
	}
?>