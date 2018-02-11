<?php include("header.php");?>
		<div id="login-wrap">
			<form id="login" action="login_logout.php" method="post">
				<select name="username" id="username">
					<?php $users = getUsers();
						for($i=0;$i<count($users);$i++){
							print_r($users[$i]);
							$user = $users[$i]['username'];
							echo "<option value='$user' ".(isset($_GET['username'])?($_GET['username']==$user?"selected":""):"").">".ucfirst($user)."</option>";
						} 
					?>
				</select>
				<input placeholder="Password" class="<?=(isset($_GET['error'])?"error":"");?>" type="password" id="password" name="password" <?=(isset($_GET['error'])?"autofocus":"");?> />
				<input type="hidden" name="inout" value="in"/>
				<input type='hidden' name="computer" value="<?=$_GET['computer'];?>"/>
			</form>
		</div>
	<script>
		$("#password").keypress(function (e) {
			$(this).removeClass("error");
			  if (e.which == 13) {
				$('form#login').submit();
				return false;    //<---- Add this line
			  }
		});
	</script>
<?php include("footer.php");?>