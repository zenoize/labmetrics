<?php
	include "../classes/Database.php";
	include "../bin/config.php";
	
	$database = new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
	$con = $database->connect();
	$methods = array(
		"ban_account"=>function(){
			$id = (int)$_GET['id'];
			$sql = "UPDATE bots SET status = 'BANNED' WHERE id = '$id'";
			return updateDB($sql);
		},
		"tutorial_island_complete"=>function(){
			$sql  = "UPDATE bots set status = 'TUTORIAL_COMPLETE' WHERE ";
			if(@$_GET['username'])$sql .= "username = '$_GET[username]'";
			elseif(@$_GET['id'])$sql .= "id = '$_GET[id]'";
			elseif(@$_GET['email'])$sql .= "email = '$_GET[email]'";
			return updateDB($sql);
		}
	);
	
	if(array_key_exists($_GET['do'],$methods)){
		$response = array("status"=>"success","response"=>$methods[$_GET['do']]());
		echo json_encode($response,1);
	}
	else{
		echo json_encode(array("status"=>"fail","error"=>"Method {".$_GET['do']."} does not exists"),1);
	}
	
	function updateDB($sql){
		global $con;
		$query = $con->prepare($sql);
		if($query->execute())return array("updated"=>true);
		else return array("updated"=>false);
	}
?>