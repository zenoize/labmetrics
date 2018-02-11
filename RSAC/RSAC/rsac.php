<?php

	$num_of_accounts = $argv[1];
	$created = 0;
	set_time_limit ( $num_of_accounts * 250 );
	include "classes/InfoGen.php";
	include "classes/ProxyRotator.php";
	include "classes/Database.php";
	include "classes/RecaptchaSolver.php";
	include "bin/config.php";
	
	$config = array(
		'googlekey' => GOOGLE_KEY,
		'apikey' => API_KEY,
		'pageurl' => PAGE_URL
	);
	
	$infogen = new InfoGen("bin/names.csv");
	$proxy_rotator = new ProxyRotator();
	$database = new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
	$con = $database->connect();
	$solver = new RecaptchaSolver($config);
	
	function CreateAccount(){
		global $num_of_accounts;
		global $created;
		global $infogen;
		global $proxy_rotator;
		global $con;
		global $solver;
		
		$start_time = time();
		$proxy = $proxy_rotator->getProxy();
		$data = array();
		$data['age'] = trim($infogen->getAge());
		$data['name'] = trim($infogen->generateName());
		$data['email'] = trim($infogen->generateEmail());
		$data['password'] = trim($infogen->generatePassword());
		$data['ip'] = $proxy['ip'];
		$data['port'] = $proxy['port'];
		$solution = $solver->solveCaptcha();
		$result = shell_exec('node '.dirname(__FILE__).'/node/rsac.js "'.$data['age'].'" "'.$data["name"].'" "'.$data["password"].'" "'.$data["email"].'" "'.$solution.'" "'.$data['ip'].'" "'.$data['port'].'"');
		$result = json_decode($result,1);
		shell_exec('Taskkill /IM phantomjs.exe /F');
		$end_time = time();
		$creation_time = $end_time - $start_time;
		$sql = "INSERT INTO bots (age,username,email,password,ip,port,creation_date) VALUES('$data[age]', '$data[name]', '$data[email]', '$data[password]', '$data[ip]', '$data[port]', now())";
		$query = $con->prepare($sql);
		$query->execute();
		$data['id'] = $con->lastInsertId();
		if($result['status'] == "fail"){
			$data['status'] = 'FAILED';
			$error = $result['error'];
			$data['error'] = $result['error'];
			$query = $con->prepare("update bots set status = 'FAILED' , creation_time = $creation_time,error = '$error' WHERE id = '$data[id]'");
		}elseif($result['status']=='success'){
			$data['status'] = 'NEW';
			$query = $con->prepare("update bots set status = 'NEW' , creation_time = $creation_time WHERE id = '$data[id]'");
			$data['tutorial_island'] = file_get_contents("http://localhost/RSAC/bot_server/?proxy=$data[ip]:$data[port]&email=$data[email]&password=$data[password]&script=".TUTORIAL_ISLAND."&show_interface=true");
			$created++;
		}
		$query->execute();		
		if($created<$num_of_accounts)
			CreateAccount();
		//echo json_encode($data,1);
	}
	
	CreateAccount();
?>