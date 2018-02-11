<?php

	include("database.php");
	$query = $_GET['query'];
	$sth = $dbh->prepare($query);
	$sth->execute();
	$results = $sth->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($results,1);

?>