<?php
	function Login($username, $password) {
		//Authenticates a user
		require_once('PlexUser.class.php'); //Ensure that the PlexUser class has been loaded.
		$User = new PlexUser(null, $username, $password);
		if ($User->getAuth()){
			return $User->getAuth();
		} else {
			echo '<script language="javascript">';
			echo 'alert("Username and Password were incorrect.")';
			echo '</script>';
			unset($_SESSION['ytbuser']);
			return false;
		}
	}
	
	function printPlexEmails(){
		//Print plex users email addresses
		$sxml = simplexml_load_file("https://plex.tv/pms/friends/all?X-Plex-Token=" . $GLOBALS['ini_array']['token']);
		foreach (($sxml->User) as $user){
			print $user['email']."<br>";
		}
	}
	
	function CookieLogin($token){
		require_once('PlexUser.class.php'); //Ensure that the PlexUser class has been loaded.
		$User = new PlexUser($token);
		return $User->getAuth();
	}
	
	function AuthAndLeave(){
		header("Location: index.php"); //Change this to read from the current user header. This will then redirect user to where they WERE going.
		exit;
	}
?>