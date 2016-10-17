<?php
	function plexpyAPI($command, $cached = false){
		//Get API cmd from PlexPy
		if ($cached != false) {
			if (array_key_exists('plexpy', $_SESSION)) {
				if (array_key_exists($cached, $_SESSION['plexpy'])) {
					return $_SESSION['plexpy'][$cached];
				}
			}
		}

		//Load module config
		$module_config = parse_ini_file("config.module.ini.php"); //Config file that has configurations for site.

		//Get the users friendly name from PlexPy
		$pyapi = $module_config['pp_api'];

		$host = "https://localhost:8181/plexpy/api/v2?apikey=". $pyapi . "&cmd=" . $command;
		$process = curl_init($host);
                curl_setopt($process, CURLOPT_HEADER, 0);
                curl_setopt($process, CURLOPT_TIMEOUT, 30);
                curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($process);
                $curlError = curl_error($process);
                curl_close($process);
                $json = json_decode($data, true);

		if ($cached != false){
			$_SESSION['plexpy'][$cached] = $json;
		}

		return $json;
	}
?>
