<?php
//error_reporting(0);
$servername = "localhost";
$username = "root";
$database="lab_metrics";
$password = "";

$dbh = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
session_start();

function dateIntervalToSeconds($dateInterval)
{
    $reference = new DateTimeImmutable;
    $endTime = $reference->add($dateInterval);

    return $endTime->getTimestamp() - $reference->getTimestamp();
}


function getComputerIdByName($computer){
	//Get computer id by computer name
		global $dbh;
		
		$sth = $dbh->prepare("SELECT id FROM computers WHERE computer_name = :computer");
		$sth->execute(array(":computer"=>$computer));
		$computer_id = $sth->fetchAll()[0];
		return $computer_id['id'];
}

function getUsers(){
	// use the connection here
	global $dbh;
	$computer_id = getComputerIdByName($_GET['computer']);
	$sth = $dbh->prepare('SELECT username FROM users WHERE computer_id = :computer_id ORDER BY log_out_time DESC LIMIT 1');
	$sth->execute(array(":computer_id"=>$computer_id));
	$last_user = $sth->fetchAll();
	if(count($last_user)>0){
		$last_user = $last_user[0];
		$sth = $dbh->prepare('SELECT username FROM users WHERE username != :last_user ORDER BY log_out_time DESC');
		$sth->execute(array(":last_user"=>$last_user[0]));
		$result = $sth->fetchAll();
		array_unshift($result,$last_user);
	}else{
		$sth = $dbh->prepare('SELECT username FROM users');
		$sth->execute();
		$result = $sth->fetchAll();
	}	
	return $result;
}

function getUserStatus($user_id){
	global $dbh;
	$sth = $dbh->prepare("SELECT status from users where id=:user_id");
	$sth->execute(array(":user_id"=>$user_id));
	$result = $sth->fetchAll()[0];
	return $result['status'];

}

function getUserRole($user_id){
	global $dbh;
	$sth = $dbh->prepare("SELECT role from users where id=:user_id");
	$sth->execute(array(":user_id"=>$user_id));
	$result = $sth->fetchAll()[0];
	return $result['role'];
}

function startTimer(){
	global $dbh;
	$user_id = $_SESSION['user_id'];
	$case_type = $_SESSION['case_type'];
	$computer_id = $_SESSION['computer_id'];
	$operation_id = $_SESSION['operation_id'];
	$cases = $_SESSION['cases'];
	$sql_array = array(
		":user_id"=>$user_id,
		":operation_id"=>$operation_id,
		":case_type"=>$case_type,
		":computer_id"=>$computer_id,
		":amount"=>$cases
	);
	try{
		$sth = $dbh->prepare("INSERT INTO cases (user_id,amount,operation_id,case_type,computer_id,start_time) VALUES(:user_id,:amount,:operation_id,:case_type,:computer_id,NOW())");
		$sth->execute($sql_array);
		$_SESSION['case_id'] = $dbh->lastInsertId();
		$_SESSION['case_start'] = date_create();
	}
	catch(Exception $e){
		var_dump($e);
	}
}

function stopTimer(){
	global $dbh;
	$computer_id = $_SESSION['computer_id'];
	$case_id = $_SESSION['case_id'];
	$now = date_create();
	$case_start = $_SESSION['case_start'];
	$diff = date_diff($case_start,$now);
	$case_time = dateIntervalToSeconds($diff);
	$sth = $dbh->prepare("UPDATE cases set end_time = NOW(),case_time=:case_time WHERE id = :case_id");
	$sth->execute(array(":case_id"=>$case_id,":case_time"=>$case_time));
}

function getCaseTypeIdByName($case_type_name){
	global $dbh;
	$sth = $dbh->prepare("SELECT id from case_types where type_name = :case_type_name");
	$sth->execute(array(":case_type_name"=>$case_type_name));
	$results = $sth->fetchAll()[0];

	return $results['id'];
}

function toggleBreak($user_id,$case_id){
	global $dbh;
	$status = getUserStatus($user_id);
	if($status==2){
		$break_id = $_SESSION['break_id'];
		$sth = $dbh->prepare("UPDATE breaks SET end_time = NOW() WHERE id=:break_id; UPDATE users set status = 1 WHERE id = :user_id");
		$sth->execute(array(":break_id"=>$break_id,":user_id"=>$user_id));
		$start = $_SESSION['break_start'];
		$now = date_create();
		$diff = date_diff($start,$now);
		$break_time =dateIntervalToSeconds($diff);
		$sth = $dbh->prepare("UPDATE cases SET break_time = break_time + :break_time WHERE id = :case_id");
		$sth->execute(array(":break_time"=>$break_time,":case_id"=>$case_id));
		unset($_SESSION['break_id']);
		unset($_SESSION['break_start']);
		$_SESSION['just_breaked'] = true;
	}else{
		$sth = $dbh->prepare("INSERT INTO breaks (user_id,start_time) VALUES(:user_id,NOW()); UPDATE users set status = 2 WHERE id = :user_id");
		$sth->execute(array(":user_id"=>$user_id));
		$_SESSION['break_id'] = $dbh->lastInsertId();
		$_SESSION['break_start'] = date_create();

	}
}

function getAverageCaseTime($case_type,$user_id){
	global $dbh;
	$sth = $dbh->prepare("SELECT * FROM cases WHERE user_id=:user_id AND case_type = :case_type");
	$sth->execute(array(":user_id"=>$user_id,":case_type"=>$case_type));
	$results = $sth->fetchAll();
	$number_of_cases =count($results);
	if($number_of_cases>0){
		$case_times = 0;
		$break_times = 0;
		for($i=0;$i<$number_of_cases;$i++){
			$case = $results[$i];
			$case_times+=floatval($case['case_time']);
			$break_times+=floatval($case['break_time']);
		}
		$work_time = $case_times - $break_times;
		$average_time = $work_time/$number_of_cases;
	}else{
		$sth = $dbh->prepare("SELECT default_average_time from case_types where id = :case_type");
		$sth->execute(array(":case_type"=>$case_type));
		$results = $sth->fetchAll()[0];
		$average_time = $results['default_average_time'];
	}
	return round($average_time/60,2);
}

function getCaseTypes(){

	global $dbh;
	$sth = $dbh->prepare("SELECT * FROM case_types");
	$sth->execute();
	$results = $sth->fetchAll();
	return $results;
}

function getOperations(){

	global $dbh;
	$sth = $dbh->prepare("SELECT * FROM operations");
	$sth->execute();
	$results = $sth->fetchAll();
	return $results;
}


function getAverageCaseTimeByUserId($user_id,$case_type=null){
	global $dbh;
	$query = "SELECT * FROM cases WHERE user_id=:user_id".($case_type!=false?" AND case_type = :case_type":"");

	$db_array = array(":user_id"=>$user_id);
	if($case_type!=false){
		$db_array[":case_type"] = $case_type;
	}
	$sth = $dbh->prepare($query);
	$sth->execute($db_array);
	$results = $sth->fetchAll();
	$number_of_cases =count($results);
	if($number_of_cases>0){
		$case_times = 0;
		$break_times = 0;
		for($i=0;$i<$number_of_cases;$i++){
			$case = $results[$i];
			$case_times+=floatval($case['case_time']);
			$break_times+=floatval($case['break_time']);
		}
		$work_time = $case_times - $break_times;
		$average_time = $work_time/$number_of_cases;
	}else{
		$sth = $dbh->prepare("SELECT default_average_time from case_types where id = :case_type");
		$sth->execute(array(":case_type"=>$case_type));
		$results = $sth->fetchAll()[0];
		$average_time = $results['default_average_time'];
	}
	return round($average_time/60,2);
}

function getDepartmentAverage(){
	$users = getUsers();
	$average_times = 0;
	for($i=0;$i<countet($users);$i++){
		$user = $users[$i];
		$user_average = getAverageCaseTimeByUserId($user['id']);
		$average_times += $user_average;
	}
	$department_average = $average_times / count($users); 
	return round($department_average,2);
}

?>