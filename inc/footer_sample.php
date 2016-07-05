<?php
	include_once('dynamic_management.module.php');
	$management_items = dynamicManagement($User);
?>
<footer class="page-footer light-blue">
<div class="container">
    <div class="row">
		<div class="col l6 s12">
		  <h5 class="white-text">Your Tech Base</h5>
		  <p class="grey-text text-lighten-4">We are a team of cool kids bringing you content for your enjoyment.</p>
		</div>
		<div class="col l3 m3 s4">
			<h5 class="white-text">News</h5>
			<ul>
				<li><a class="white-text" href="https://getgrav.org/">Blog</a></li>
			</ul>
		<?php if (count($management_items) == 0) { ?>
		</div>
		<div class="col l3 m3 s4">
		<?php } ?>
			<h5 class="white-text">Help & Support</h5>
			<ul>
				<li><a class="white-text" href="https://getgrav.org/">FAQ</a></li>
				<li><a class="white-text" href="https://github.com/hjone72/Bumpy-Booby">Helpdesk</a></li>
			</ul>
		</div>
		<div class="col l3 m3 s4">
			<h5 class="white-text">Features</h5>
			<ul>
				<li><a class="white-text" href="https://plex.tv">Plex</a></li>
				<li><a class="white-text" href="https://github.com/tidusjar/PlexRequests.Net">Requests</a></li>
				<li><a class="white-text" href="http://vaemendis.net/ubooquity/">Comics</a></li>
				<li><a class="white-text" href="/?page=invite">Invite</a></li>
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
  <div class="container">
  Made by YTB!
  </div>
</div>
</footer>