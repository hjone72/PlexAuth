<?php
	if (isset($_POST['PlexEmail'])){
		$host = "https://plex.tv/users/sign_in.json";
		$username = $_POST['PlexEmail'];
		$password = $_POST['PlexPassword'];
		$header = array(
						   'Content-Type: application/xml; charset=utf-8',
						   'Content-Length: 0',
						   'X-Plex-Client-Identifier: 8334-8A72-4C28-FDAF-29AB-479E-4069-C3A3',
						   'X-Plex-Product: YTB-SSO',
						   'X-Plex-Version: v1.0',
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

		$user_token = $json['user']['authentication_token'];

		$auth = false;
		if (!array_key_exists("error",$json)){
			//Load static values from ini. $ini_array['token']
			$ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/config.ini.php");
			$user_info = simplexml_load_file('https://plex.tv/users/account?X-Plex-Token=' . "$user_token");

			$ClaimedUser = ($user_info->attributes()['username']);
			$Token = $ini_array['token'];
			$sxml = simplexml_load_file("https://plex.tv/pms/friends/all?X-Plex-Token=" . "$Token");

			foreach (($sxml->User) as $user){
				if (strcmp(strtolower($ClaimedUser), strtolower($user['username'])) == 0){
					$auth = true;
					break;
				}
			}

			if ($ClaimedUser == $ini_array['plexowner']){
				$auth = true;
			}
		}

		if ($auth){
			header('X-Username: ' . 'test', true, 200);
			$ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/config.ini.php");
			setcookie($ini_array['cookie'], $user_token, time() + 129600, '/', $ini_array['domain'], true);
			header("Refresh:0");
		} else {
			header('X-Username: ' . 'test', true, 401);
		}
	}