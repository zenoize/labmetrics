<?php
	include "../classes/Database.php";
	include "../bin/config.php";
	
	$database = new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
	$con = $database->connect();
	$methods = array(
		"create_new_account"=>function(){
			$number_of_accounts = 1;
			if(@$_GET['n'])$number_of_accounts = (int)$_GET['n'];
			$WshShell = new COM("WScript.Shell");
			$command = "php.exe ".dirname(__DIR__)."\\rsac.php $number_of_accounts";
			$oExec = $WshShell->Run(utf8_decode($command), 0, false);
			return array("number_of_accounts_started"=>$number_of_accounts,"Command"=>"php ".dirname(__DIR__)."/rsac.php");
		}
	);
	
	if(array_key_exists($_GET['process'],$methods)){
		$response = array("status"=>"success","response"=>$methods[$_GET['process']]());
		echo json_encode($response,1);
	}
	else{
		echo json_encode(array("status"=>"fail","error"=>"Method {".$_GET['process']."} does not exists"),1);
	}
	
	function getResults($sql){
		global $con;
		$query = $con->prepare($sql);
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
?>