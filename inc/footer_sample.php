<?php
	include_once('dynamic_management.module.php');
        include_once('dynamic_menu.module.php');
	$management_items = dynamicManagement($User);

        $menu_items_HaS = dynamicMenu("Help & Support");
        $menu_items_F = dynamicMenu("Features");
?>
<footer class="page-footer plex-black">
<div class="container">
	<div class="row">
		<div class="col l3 m3 s12">
			<img id="ytb-logo" class="responsive-img" src="images/icons/YTB-logo.svg" width="250" alt="Your Tech Base Logo" title="Your Tech Base Logo">
		</div>
		<div class="col l3 m3 s4">
			<h5 class="white-text">News</h5>
			<ul>
				<li><a class="white-text" href="https://getgrav">Blog</a></li>
			</ul>
		<?php if (count($management_items) == 0) { ?>
		</div>
		<div class="col l3 m3 s4">
		<?php } ?>
			<h5 class="white-text">Help & Support</h5>
			<ul>
				<?php
				printMenu(null, null, $menu_items_HaS, false, "white-text");
				?>
			</ul>
		</div>
		<div class="col l3 m3 s4">
			<h5 class="white-text">Features</h5>
			<ul>
                                <?php
                                printMenu(null, null, $menu_items_F, false, "white-text");
                                ?>
			</ul>
		</div>
		<div class="col l3 m3 s4">
			<?php
				if (count($management_items) > 0) {
					print '<h5 class="white-text">Management</h5>';
					print '<ul>';
					foreach ($management_items as $item => $info) {
						print '<li><a class="white-text" href="' . $info . '">' . $item . '</a></li>';
					}
					print '</ul>';
				}
			?>
		</div>
	</div>
</div>
<div class="footer-copyright">
<?php
	include_once('plexpyAPI.module.php');
        $stats = plexpyAPI('get_libraries', 'library_stats')['response']['data'];
	$stat_array = array();
        foreach ($stats as $section) {
		$stat_array[$section['section_name']] = $section['count'];
	        if ($section['section_type'] == 'show') {
			$stat_array["Episodes"] = $section['child_count'];
	        }
        }
?>

<div class="container">
    <div class="row">
        <div class="col l3">
            Made by YTB!
        </div>
        <div class="col l9 right-align">
            <strong>HD Movies: </strong><?php print $stat_array['HD Movies']; ?> <span class="plex-orange-text">&#124;</span>
            <strong>SD Movies: </strong><?php print $stat_array['SD Movies']; ?> <span class="plex-orange-text">&#124;</span>
            <strong>TV Shows: </strong><?php print $stat_array['TV Shows']; ?> <span class="plex-orange-text">&#124;</span>
            <strong>Episodes: </strong><?php print $stat_array['Episodes']; ?>
        </div>
    </div>
</div>
</div>
</footer>
