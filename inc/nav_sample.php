<?php
	include_once('dynamic_management.module.php');
	$management_items = dynamicManagement($User);
?>
<div class="navbar-fixed">
 
<ul id="dropdown1" class="dropdown-content">
	<li><a href="https://getgrav.org/">FAQ</a></li>
	<li><a href="https://github.com/hjone72/Bumpy-Booby">Helpdesk</a></li>
</ul>
<ul id="dropdown2" class="dropdown-content">
	<li><a href="https://plex.tv">Plex</a></li>
	<li><a href="https://github.com/drzoidberg33/plexpy">Plex Statistics</a></li>
	<li><a href="https://github.com/tidusjar/PlexRequests.Net">Requests</a></li>
	<li><a href="http://vaemendis.net/ubooquity/">Comics</a></li>
	<li><a href="/?page=invite">Invite</a></li>
</ul>

<?php
	if (count($management_items) > 0) {
		print '<ul id="dropdown3" class="dropdown-content">';
		foreach ($management_items as $item => $info) {
			print '<li><a href="' . $info . '">' . $item . '</a></li>';
		}
		print '</ul>';
	}
?>

<ul id="dropdown4" class="dropdown-content">
	<li><a href="/?page=signout">Sign Out</a></li>
</ul>

  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Your Tech Base</a>
		<ul class="right hide-on-med-and-down">
			<li><a href="https://getgrav.org/">Blog</a></li>
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
				<li><a href="https://getgrav.org/">Blog</a></li>
			<h5 class="black-text text-lighten-3 center-align">Help & Support</h5>
				<li><a href="https://getgrav.org/faq">FAQ</a></li>
				<li><a href="https://github.com/hjone72/Bumpy-Booby">Helpdesk</a></li>
			<h5 class="black-text text-lighten-3 center-align">Features</h5>
				<li><a href="https://plex.tv" target="_blank">Plex</a></li>
				<li><a href="https://github.com/drzoidberg33/plexpy" target="_blank">Plex Statistics</a></li>
				<li><a href="https://github.com/tidusjar/PlexRequests.Net" target="_blank">Requests</a></li>
				<li><a href="http://vaemendis.net/ubooquity/" target="_blank">Comics</a></li>
				<li><a href="/?page=invite">Invite</a></li>
			<?php
				if (count($management_items) > 0) {
					print '<h5 class="black-text text-lighten-3 center-align">Management</h5>';
					foreach ($management_items as $item => $info) {
						print '<li><a href="' . $info . '" target="_blank">' . $item . '</a></li>';
					}
				}
			?>
		</ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
     
</div>