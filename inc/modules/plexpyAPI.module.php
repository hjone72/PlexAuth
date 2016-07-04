<?php
	function plexpyAPI($command){
		//Get Plex Library stats from PlexPy
		//Load module config
		$module_config = parse_ini_file("config.module.ini.php"); //Config file that has configurations for site.

		//Get the users friendly name from PlexPy
		$pyapi = $module_config['pp_api'];
		$pyurl = $module_config['pp_url'];
		$return = json_decode(file_get_contents($pyurl . "/plexpy/api/v2?apikey=". $pyapi . "&cmd=" . $command));
		return $return;
	}
?>