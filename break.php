<?php
	include("database.php");
	toggleBreak($_SESSION['user_id'],$_SESSION['case_id']);
	header("location:timer.php");
?>