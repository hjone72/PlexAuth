<?php
	function getGravDetails($User) {
		//Print data in a way that Grav is expecting.
		include_once('dynamic_management.module.php');
		$management_array = dynamicManagement($User);
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
						"gravPerms" => $gravPerms
					);
		return $data;
	}
?>