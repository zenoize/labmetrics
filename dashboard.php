<?php
	$page = 'dashboard';
	include("header.php");
	if(getUserRole($_SESSION['user_id'])<2){
		?>
		<h1>GO HOME</h1>
		<?php
	}else{
	
?>
	

<?php
	}
	include("footer.php");

?>