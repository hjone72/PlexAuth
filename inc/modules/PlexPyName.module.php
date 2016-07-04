<?php
	//Load module config
	$module_config = parse_ini_file("config.module.ini.php"); //Config file that has configurations for site.

	//Get the users friendly name from PlexPy
	if ($User->getAuth()){
		if (!$User->getName()[2]){
			require_once('plexpyAPI.module.php');
			$users = plexpyAPI('get_user_names');
			foreach ($users->response->data as $user) {
				if ($user->user_id == $User->getID()){
					$name = explode(' ', $user->friendly_name);
					$User->setName($name);
					break;
				}
			}
		}
	}
?>