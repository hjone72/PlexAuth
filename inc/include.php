<?php
	//Include all the files needed for PlexAuth
	$path = __DIR__;
	$ini_array = parse_ini_file($path."/config.ini.php"); //Config file that has configurations for site.
	$GLOBALS['ini_array'] = $ini_array;
	session_start(); //Start PHP session.
	require_once('plex_function.php');
	require_once('PlexUser.class.php');
	require_once('RememberMe.php');
?>