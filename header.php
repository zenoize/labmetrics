<?php
	if(!isset($page)){
		$page ="default";
	}
	include("database.php");
	
?>
<html>
	<head>
		<title>Lab Metrics by JaySquiz</title>
		<link href="css.css" rel="stylesheet" type="text/css"/>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<script src="jquery.js"></script>
		<link rel="icon" type="image/png" sizes="96x96" href="favicon96x96.png"/>
		<link rel="icon" type="image/png" sizes="32x32" href="favicon32x32.png"/>
		<meta name="theme=color"  content="#333"/>
	</head>
	<body id="<?=$page;?>">
		<div id="full_size"></div>
		<?php 
		if(isset($_SESSION['username']) && $page!="dashboard"){?>
			<ul id="main_menu" class="menu">
				<li>
					<a href="#"><img src="https://image.flaticon.com/icons/png/128/56/56763.png"/></a>
					<ul id="drop_down_menu" class="drop_down">
						<?php

						if(isset($_SESSION['user_id'])){
							if(getUserRole($_SESSION['user_id'])>=2){?>
							<li>
								<a href='dashboard.php' target="_blank">Admin Dashboard</a>
							</li>
						<?php }
						}	?>
						<?php if($page=="timer" && getUserStatus($_SESSION['user_id'])!=2){?>
						<li>
							<a href="break.php">Break</a>
						</li>
						<?php } ?>
						<li>
							<a href="login_logout.php">Logout</a>
						</li>
						<li>
							<a href="login_logout.php">Request Help</a>
						</li>
					</ul>
				</li>
			</ul>
			<script>
				$("#full_size").click(function(){
					$("#drop_down_menu").hide();
				})
				$("#main_menu>li>a,#main_menu>li>ul>li>a").click(function(){
					$("#drop_down_menu").toggle();
				})
				$(document).mouseleave(function () {
					$("#drop_down_menu").hide();
				});
			</script>
		<?php } ?>
		<div id="logo">
			<img src="logo.png"/>
		</div>
		<div id="container">
		
			