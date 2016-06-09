<?php
	$path = __DIR__;
	//Adds inc directory to includes. Ensure this actually adds the path to where your files are located. /var/www/PlexAuth/inc
	set_include_path(get_include_path() . PATH_SEPARATOR . $path . '/inc');
	//Grab the GET parameters and add to session.
	if (isset($_GET['return'])){
		if ($_GET['return'] != "") {
			$_SESSION['return_url'] = $_GET['return'];
		}
	}
	require_once('include.php');
?>
