<?php
	$page = "abutments";
	include("header.php");
	?>
	<div class="case_amount" id='link_wrap'>
	<?php
		$_SESSION['case_type'] = getCaseTypeIdByName($_GET['type']);

	$total_abutments = 16;
	for($i=1;$i<=$total_abutments;$i++){
		?>
			<a href='timer.php?abutments=$i'><?=$i?></a>
		<?php
	}
	?>
</div>
<?php
	include("footer.php");
?>