<?php
require 'config/constants.php';
require 'config/paths.php';
require 'config/database.php';
function __autoload($class)
{
	_loadFile($class);
}
function _loadFile($class,$folder = false){
	
	if(!$folder && $GLOBALS['PLUGIN'])$folder = 'plugins/'.$GLOBALS['PLUGIN'] .'bin/libs/';	
	else
	$folder = LIBS;
	if(file_exists($folder)){
		$files = scandir($folder);
		$lowers =array_map('strtolower', $files);
		$index = array_search(strtolower($class.".php"),$lowers);
		if(file_exists($folder.$files[$index]))
			require($folder . $files[$index]);
		else
			_loadFile($class,LIBS);
	}else{
		_loadFile($class,LIBS);
	}
}
//session_start();
$app = new Bootstrap();
?>