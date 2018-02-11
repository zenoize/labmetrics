$(document).ready(function(){
	if($("#error_response span").length){
		$time = parseInt($("#error_response span").html());
		setInterval(function(){
			$time--;
			if($time>=0){
				$("#error_response span").html($time);
			}
		},60000);
	}
});
