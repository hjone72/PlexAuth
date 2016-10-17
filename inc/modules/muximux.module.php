<?php
print '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>';
print '<script src="js/muximux.js"></script>';
function frameContent($menu_items) {
        if (empty($items)) $items = '';
        foreach ($menu_items as $item => $info) {
		if (is_array($info)) {
			$enabled = $info[1];
		} else {
			$enabled = true;
		}

                if (is_array($info)) {
                        $info = $info[0];
                }

		if ($enabled) {
	                if ($item != 'DEFAULT'){
				$items .= '<li data-content="'. $item . '"><iframe style="width: 100%" scrolling="auto" data-src="'. $info . '"></iframe></li>';
			} else {
				$items .= '<li data-content="'. $item . '"><iframe class="iselected" style="width: 100%" scrolling="auto" data-src="'. $info . '" src="' . $info . '"></iframe></li>';
			}
		}
        }
        return $items;
}
?>
