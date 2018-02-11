<?php 
$page = "operation";
include("header.php");

?>
	<div id='link_wrap'>
		<?php 
			$operations = getOperations();

			for($i=0;$i<count($operations);$i++){
				$operation = $operations[$i];
				if($operation['operation_name']=="Order Creation"){ ?>
					<a href='case_amount.php?type=<?=$operation['id'];?>'><?=$operation['operation_name'];?></a>
			<?php	}else{
			?>
					<a href='case_type.php?type=<?=$operation['id'];?>'><?=$operation['operation_name'];?></a>
			<?php 
				} 

			}
		?>
	</div>
<?php include("footer.php");?>