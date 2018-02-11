<?php
	include "../classes/Database.php";
	include "../bin/config.php";
	
	$database = new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
	$con = $database->connect();
	$methods = array(
		"banned"=>array("description"=>"","method"=>function(){
			$sql = "SELECT * FROM bots where status = 'BANNED'";
			return getResults($sql);
		}),
		"newest"=>array("description"=>"","method"=>function(){
			$sql = "SELECT * FROM bots where status = 'NEW' order by id DESC limit 1";
			return getResults($sql);
		}),
		"new"=>array("description"=>"","method"=>function(){
			$sql = "SELECT * FROM bots where status = 'NEW'";
			return getResults($sql);
		}),
		"active"=>array("description"=>"","method"=>function(){
			$sql = "SELECT * FROM bots WHERE status = 'ACTIVE'";
			return getResults($sql);
		}),
		"established"=>array("description"=>"","method"=>function(){
			$sql = "SELECT * FROM bots where status = 'ESTABLISHED'";
			return getResults($sql);
		}),
		"info"=>array("description"=>"","method"=>function(){
			$id = (int)$_GET['id'];
			$sql = "SELECT * FROM bots WHERE id='$id'";
			return getResults($sql);
		}),
		"creation_time_stats"=>array("description"=>"","method"=>function(){
			$sql = "SELECT creation_time from bots WHERE status !='CREATING' order by creation_time ASC";
			$results = getResults($sql);
			$array = array();
			$sum = 0;
			$array['fastest_creation'] = $results[0]['creation_time'];
			$array['slowest_creation'] = $results[count($results)-1]['creation_time'];
			foreach($results as $result){
				$sum += (int)$result['creation_time'];
			}
			$array['average_creation'] = round($sum / count($results),2);
			return $array;
		})
	);
	if(@$_GET['docs']){
		foreach($methods as $key=>$value){
			echo $key .": ".$value['description']."<br>"; 
		}
		die();
	}
	if(array_key_exists($_GET['return'],$methods)){
		$response = array("status"=>"success","response"=>(@$_GET['count_only']?count($methods[$_GET['return']]()):$methods[$_GET['return']]['method']()));
		echo json_encode($response,1);
	}
	else{
		echo json_encode(array("status"=>"fail","error"=>"Method {".$_GET['return']."} does not exists"),1);
	}
	
	
	function getResults($sql){
		global $con;
		$query = $con->prepare($sql);
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
?>