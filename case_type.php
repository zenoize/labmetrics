<?php
	$page = "case_type";
	include("header.php");
	$_SESSION['operation_id'] = $_GET['type'];
	?>
	<div id='link_wrap'>
	<?php
	$case_types = getCaseTypes();
	for($i=0;$i<count($case_types);$i++){

		$case_type = $case_types[$i];
		?>
			<a href="abutments.php?type=<?=$case_type['type_name'];?>"><?=ucwords($case_type['type_name']);?></a>
		<?php
	}
	?>
	</div>

	<?php 
	include("footer.php");

?>