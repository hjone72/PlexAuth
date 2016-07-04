<?php
	function dynamicManagement($User) {
		//Determine if management appears and what items should appear.
		$management_items = array(
			"SickRage" => array ("sickrage", "https://sickrage"),
			"Couchpotato" => array ("couchpotato", "https://couchpotato"),
			"Sonarr" => array ("sonarr", "https://sonarr"),
			"NZBget" => array ("nzbget", "https://nzbget"),
			"HTPC" => array ("htpc", "https://htpc"),
			"Blog Admin" => array ("grav", "https://blog/admin")
		);
		$return_items = array();
		foreach ($management_items as $item => $info) {
			if ($User->authURI($info[0])){
				$return_items[$item] = $info[1];
			}
		}
		return $return_items;
	}
?>