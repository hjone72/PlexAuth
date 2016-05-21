<?php
	function Login($username, $password) {
		//Authenticates a user
		//URL to get users details from.
		$host = "https://plex.tv/users/sign_in.json";
		//Header that will be passed to Plex. Details from this will appear in the users Plex.tv 'devices' section.
		$header = array(
						   'Content-Type: application/xml; charset=utf-8',
						   'Content-Length: 0',
						   'X-Plex-Client-Identifier: 8334-8A72-4C28-FDAF-29AB-479E-4069-C3A3',
						   'X-Plex-Product: YTB-SSO',
						   'X-Plex-Version: v2.0',
						   );
		$process = curl_init($host);
		curl_setopt($process, CURLOPT_HTTPHEADER, $header);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($process, CURLOPT_POST, 1);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($process);
		$curlError = curl_error($process);
		$json = json_decode($data, true);
		if (!array_key_exists("error",$json)){
			require_once('PlexUser.class.php'); //Ensure that the PlexUser class has been loaded.
			$User = new PlexUser($json['user']['authentication_token']);
			return $User->getAuth();
		} else {
			echo '<script language="javascript">';
			echo 'alert("Username and Password were incorrect.")';
			echo '</script>';
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