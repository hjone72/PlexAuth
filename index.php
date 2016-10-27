<?php
	$path = __DIR__;
	if (!isset($_SESSION)) {
		//Start the session if it doesn't exist.
		//We will regenerate it after login.
		session_start();
	}
	//Grab the GET parameters and add to session.
	if (isset($_GET['return'])){
		if ($_GET['return'] != "") {
			$_SESSION['return_url'] = $_GET['return'];
			$_GET['return'] = "";
		}
	}
	if (isset($_GET['auth'])){
		if ($_GET['auth'] == "basic") {
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				header('WWW-Authenticate: Basic realm="My Realm"');
				header('HTTP/1.0 401 Unauthorized');
				echo 'Auth required.';
				exit;
			} else {
				$_POST['PlexEmail'] = $_SERVER['PHP_AUTH_USER'];
				$_POST['PlexPassword'] = $_SERVER['PHP_AUTH_PW'];
			}
		}
	}

	require_once($path . '/inc/include.php');
?>
