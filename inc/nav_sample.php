<?php
	include_once('dynamic_management.module.php');
	$management_items = dynamicManagement($User);

        include_once('dynamic_menu.module.php');
?>

<div class="navbar-fixed">

<?php
    $menu_items_HaS = dynamicMenu("Help & Support");
    printMenu("dropdown1", "dropdown-content plex-black", $menu_items_HaS);

    $menu_items_F = dynamicMenu("Features");
    printMenu("dropdown2", "dropdown-content plex-black", $menu_items_F);
?>

<?php
	if (count($management_items) > 0) {
		print '<ul id="dropdown3" class="dropdown-content plex-black">';
		foreach ($management_items as $item => $info) {
			print '<li class="iframed"><a data-content="' . $item . '" href="' . $info . '">' . $item . '</a></li>';
		}
		print '</ul>';
	}
?>

<ul id="dropdown4" class="dropdown-content">
	<li><a href="./?page=signout">Sign Out</a></li>
</ul>

	<nav class="plex-black" role="navigation">
		<div class="nav-wrapper container">
			<a id="logo-container" href="/" class="brand-logo">
				<img src="images/icons/YTB-logo.svg" alt="Your Tech Base Logo" title="Your Tech Base Logo">
			</a>
			<ul class="right hide-on-med-and-down">
				<li><a href="https://blog.domain.com/">Blog</a></li>
				<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Help & Support<i class="material-icons right">arrow_drop_down</i></a></li>
				<li><a class="dropdown-button" href="#!" data-activates="dropdown2">Features<i class="material-icons right">arrow_drop_down</i></a></li>
				<?php
					if (count($management_items) > 0) {
				?>
						<li><a class="dropdown-button" href="#!" data-activates="dropdown3">Management<i class="material-icons right">arrow_drop_down</i></a></li>
				<?php
					}
				?>
				<li><a class="dropdown-button" id="client-username" href="#!" data-activates="dropdown4"><?php print $User->getUsername()?>&nbsp;<img src="<?php print $User->getThumb()?>" alt="" class="circle" id="client-picture"></a></li>
			</ul>

			<ul id="nav-mobile" class="side-nav">
				<h5 class="black-text text-lighten-3 center-align">News</h5>
					<li><a href="https://blog.domain.com">Blog</a></li>
				<h5 class="black-text text-lighten-3 center-align">Help & Support</h5>
					<?php
					printMenu(null, null, $menu_items_HaS, false);
					?>
				<h5 class="black-text text-lighten-3 center-align">Features</h5>
					<?php
					printMenu(null, null, $menu_items_F, false);
                                        ?>
				<?php
					if (count($management_items) > 0) {
						print '<h5 class="black-text text-lighten-3 center-align">Management</h5>';
						foreach ($management_items as $item => $info) {
							print '<li class="iframed"><a data-content="' . $item . '" href="' . $info . '" target="_blank">' . $item . '</a></li>';
						}
					}
				?>
			</ul>
			<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
		</div>
	</nav>
</div>
