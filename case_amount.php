<?php
	$page = "case_amount";
	include("header.php");
	$_SESSION['operation_id'] = $_GET['type'];
?>
	<h2>Number of Cases</h2>
	<div class="case_amount" id='link_wrap'>
		<?php

		$amount = 16;

		for($i=1;$i<=$amount;$i++){
		?>

			<a href="timer.php?cases=<?=$i;?>"><?=$i;?></a>
		<?php
		}
		?>
	</div>


<?php
	include("footer.php");

?>