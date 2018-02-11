<?php 
	include("database.php");
	if(isset($_POST['inout'])){

		$username = $_POST['username'];
		$password = $_POST['password'];
		$computer = $_POST['computer'];
		$sth = $dbh->prepare("SELECT * FROM users WHERE username=:user AND password=:pass");
		$sth->execute(array(":user"=>$username,":pass"=>$password));
		$results = $sth->fetchAll(); 
		$number_of_rows = count($results);
		if($number_of_rows>0){
			$_SESSION['username'] = $username;
			$computer_id = getComputerIdByName($computer);
			$_SESSION['computer_id'] = $computer_id;
			$_SESSION['computer_name'] = $computer;
			$_SESSION['user_id'] = $results[0]['id'];
			
			$sth = $dbh->prepare("UPDATE users SET log_in_time =  NOW(),status = 1, computer_id=:computer_id WHERE username=:user");
			$sth->execute(array(":user"=>$username,":computer_id"=>$computer_id));
			
			header("location:operation.php");
		}else{
			header("location:login.php?computer=$computer&error=Password Incorrect&username=$username");
		}
	}
	else{

		$computer = $_SESSION['computer_id'];
		$username = $_SESSION['username'];
		$computer_name =$_SESSION['computer_name'];
		
		session_destroy();
	 	if(isset($_SESSION['case_id'])){
			stopTimer();
		}
		$sth = $dbh->prepare("UPDATE users SET log_out_time =  NOW(), status=0 WHERE username=:user");
		$sth->execute(array(":user"=>$username));

		header("location:login.php?computer=".$computer_name);
	}
?>