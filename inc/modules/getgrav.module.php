<?php
	function getGravDetails($User) {
		//Print data in a way that Grav is expecting.
		include_once('dynamic_management.module.php');
		$management_array = dynamicManagement($User);
		include_once ('dynamic_menu.module.php');
		$support_array = dynamicMenu("Help & Support");
		$feature_array = dynamicMenu("Features");

		//Send PlexPy Stats to grav.
	        include_once('plexpyAPI.module.php');
	        $stats = plexpyAPI('get_libraries', 'library_stats')['response']['data'];
	        $stat_array = array();
	        foreach ($stats as $section) {
	                $stat_array[$section['section_name']] = $section['count'];
	                if ($section['section_type'] == 'show') {
	                        $stat_array["Episodes"] = $section['child_count'];
	                }
	        }


		$gravPerms = array (
								"admin" => array (
													"login" => false,
													"super" => $User->authURI('gravSuper'),
													"pages" => $User->authURI('gravPages'),
													"maintenance" => $User->authURI('gravMaintenance'),
													"plugins" => $User->authURI('gravPlugins'),
													"themes" => $User->authURI('gravThemes')
												),
								"site" => array (
													"login" => false
												)
							);
		foreach ($gravPerms['admin'] as $permission) {
			if ($permission == true) {
				$gravPerms['admin']['login'] = true;
				$gravPerms['site']['login'] = true;
				break;
			}
		}
		$data = array (
						"id" => $User->getID(),
						"username" => $User->getUsername(),
						"fullname" => $User->getName()[0] . ' ' . $User->getName()[1],
						"thumbURL" => $User->getThumb(),
						"email" => $User->getEmail(),
						"management" => $management_array,
						"features" => $feature_array,
						"support" => $support_array,
						"plexstats" => $stat_array,
						"gravPerms" => $gravPerms
					);
		return $data;
	}
?>
