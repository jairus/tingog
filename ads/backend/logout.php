<?php
	session_start();
	session_destroy();
	
	header("location: http://tab.tingog.ph/backend/login.php");
	exit();
?>