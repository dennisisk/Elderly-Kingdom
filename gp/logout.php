<?php if (session_status() == PHP_SESSION_NONE) { session_start();} ?>
<script>
	document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; 
	window.location.href = 'index.php';
</script>