<?php
	function dynamicMenu($menu) {
		//Build array of menu items.
		//Array key is the name that will appear in the dropdown menu.
		$menu_items = array(
			"Help & Support" => array (
                                        "FAQ" => array("https://getgrav.org/", false),
                                        "Helpdesk" => array("https://github.com/hjone72/Bumpy-Booby", true)
                                        ),
			"Features" => array (
                                        "Plex" => array("https://plex.tv", false),
                                        "Plex Statistics" => array("https://github.com/JonnyWong16/plexpy", true),
					"AudioBooks" => array("https://github.com/popeen/Popeens-Subsonic", true),
                                        "Comics" => array("https://github.com/hjone72/ComicStreamer", true)
                                        )
		);
            if (isset($menu_items[$menu])){
                return $menu_items[$menu];
            } else {
                return null;
            }
	}

    function printMenu($id, $class, $menu_items, $header = true, $link_class = null) {
        if (count($menu_items) > 0) {
            if ($header) {
                print '<ul id="' . $id . '" class="' . $class . '">';
            }
            foreach ($menu_items as $item => $info) {
		if ($info[1]){
			$iframe = ' class="iframed"';
		} else {
			$iframe = '';
		}

		if (is_array($info)){
			$info = $info[0];
		}

		if ($link_class == null) {
	                print '<li' . $iframe . '><a data-content="' . $item . '" href="' . $info . '">' . $item . '</a></li>';
		} else {
			print '<li' . $iframe . '><a class="' . $link_class . '" href="' . $info . '">' . $item . '</a></li>';
		}
            }
            if ($header) {
                print '</ul>';
            }
        }
    }
?>
