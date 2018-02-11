<?php
	/*
	
	run_silent 
	
	* Add this to your php.ini file
	
	[COM_DOT_NET]
	extension=php_com_dotnet.dll
	
	*/
	
	$run_silent = true;
	if(@$_GET['show_interface']==true)$run_silent=false;
	$command = "java -jar \"OSBot.jar\" -login polymorphism:Supernova.01 -bot $_GET[email]:$_GET[password]:0000 -script $_GET[script]:Terrin.Helena18204@gmail.com-pa6ant3";
	if(@$_GET['ip'] && @$_GET['port'])
		$command .= " -proxy $_GET[ip]:$_GET[port]";
	if(@$_GET['proxy_username'] && @$_GET['proxy_password'])
		$command .= ":$_GET[proxy_username]:$_GET[proxy_password]";
	if(@$_GET['arguments'])
		$command .= ":$_GET[aguments]";
	if($run_silent)
		$command .= " -allow nointerface";
	echo "Started";
	shell_exec($command ." & pause > null");
	//$WshShell = new COM("WScript.Shell");
	//$oExec = $WshShell->Run($command, 0, false);

?>