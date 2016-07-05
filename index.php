<?php
	$path = __DIR__;
	//Grab the GET parameters and add to session.
	if (isset($_GET['return'])){
		if ($_GET['return'] != "") {
			$_SESSION['return_url'] = $_GET['return'];
			$_GET['return'] = "";
		}
	}
	require_once($path . '/inc/include.php');
?>
