<?php
	$page = "timer";
	include("header.php");
	?>
	<div id='link_wrap'>
		<?php
		$user_id = $_SESSION['user_id'];
		$_SESSION['cases'] = (isset($_GET['cases'])?$_GET['cases']:1);
		
		if(getUserStatus($user_id)==2){
			//On Break
			?>
			<a href='break.php' id="break_btn">End Break</a>
		<?php }else{
			if(isset($_SESSION['just_breaked'])){

				unset($_SESSION['just_breaked']);
			}else{
				//Timer
				if(isset($_SESSION['case_id'])){
					stopTimer();
					unset($_SESSION['case_id']);
					header("location:timer.php");
				}
				else{
					$average_time = getAverageCaseTimeByUserId($user_id,$_SESSION['case_type']);
					echo "Average Time ".$average_time;
					startTimer();
				}?>
				
		<?php 
			}
			?><a href='timer.php' id="next_button">Next</a>

		<?php }
		?>
	</div>
		<?php

	include("footer.php");
?>